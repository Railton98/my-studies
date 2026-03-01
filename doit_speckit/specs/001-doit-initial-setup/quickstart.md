# Quick Start: DoIt Initial Page Setup

**Phase**: 1 (Design) | **Date**: 2026-03-01  
**Input**: [plan.md](plan.md) + [research.md](research.md) + [data-model.md](data-model.md) + [contracts/components.md](contracts/components.md)

---

## Project Setup

### Prerequisites

- Node.js 18+
- npm (v9+)
- Next.js 16.1.6 already installed in workspace

### Install Dependencies

```bash
cd /home/tecks/Code/my-studies/doit_speckit

# Install date-fns for date utilities
npm install date-fns

# Install shadcn/ui components (if not already installed)
# Components needed: button, input, dialog, alert-dialog, card
npm install @radix-ui/react-dialog @radix-ui/react-alert-dialog @radix-ui/react-slot
```

### Verify Environment

```bash
npm list next react react-dom tailwindcss
# Expected:
# - next@16.1.6
# - react@19.2.3
# - react-dom@19.2.3
# - tailwindcss@4

npm list date-fns
# Expected: date-fns@latest (or recent stable)
```

---

## Phase 1: Setup & Configuration

### 1. Configure Tailwind @theme with Pastel Colors

**File**: `app/globals.css`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  html {
    @apply scroll-smooth;
  }
}

/* Classic Pastels Theme */
@theme {
  --color-pastel-pink: #F8C5D4;
  --color-pastel-mint: #C0F0E8;
  --color-pastel-purple: #E8D4F1;
  --color-pastel-yellow: #FFF4D4;
  --color-neutral-bg: #FAFAF8;
}

/* Optional: Define component classes for reuse */
@layer components {
  .btn-primary {
    @apply px-4 py-2 rounded bg-pastel-mint hover:bg-pastel-mint/80 text-gray-800 font-medium transition-colors;
  }
  
  .btn-secondary {
    @apply px-4 py-2 rounded border border-gray-300 hover:bg-gray-50 text-gray-800 font-medium transition-colors;
  }

  .card-base {
    @apply rounded-lg border border-gray-200 shadow-sm bg-white;
  }

  .card-urgent {
    @apply card-base bg-pastel-yellow;
  }

  .card-completed {
    @apply card-base bg-pastel-pink;
  }
}
```

### 2. Setup shadcn/ui Components

Run the shadcn CLI for each component:

```bash
# Initialize shadcn/ui (if not done)
npx shadcn-ui@latest init

# Add individual components
npx shadcn-ui@latest add button
npx shadcn-ui@latest add input
npx shadcn-ui@latest add card
npx shadcn-ui@latest add dialog
npx shadcn-ui@latest add alert-dialog
```

This creates component files in `components/ui/`.

### 3. Create Project Structure

```bash
# Create directories
mkdir -p app/components/{dashboard,forms/common}
mkdir -p app/hooks
mkdir -p app/lib
mkdir -p app/types

# Create TypeScript types
touch app/types/goal.ts

# Create utilities
touch app/lib/goals.ts
touch app/lib/storage.ts
touch app/lib/dates.ts

# Create hooks
touch app/hooks/usePersistentGoals.ts
touch app/hooks/useGoals.ts
```

---

## Phase 2: Implement Core Logic

### 1. Define Goal Types

**File**: `app/types/goal.ts`

```typescript
export interface Goal {
  id: string;
  title: string;
  endDate: string;
  createdDate: string;
  status: 'current' | 'completed';
}

export interface GoalWithComputed extends Goal {
  daysRemaining: number;
  isUrgent: boolean;
  displayDays: string;
  displayDate: string;
}
```

### 2. Implement Date Utilities

**File**: `app/lib/dates.ts`

```typescript
import {
  differenceInDays,
  format,
  parseISO,
  isToday,
  isTomorrow,
} from 'date-fns';

export function getDaysRemaining(endDate: string): number {
  return differenceInDays(parseISO(endDate), new Date());
}

export function isUrgent(endDate: string): boolean {
  const days = getDaysRemaining(endDate);
  return days <= 3 && days >= 0;
}

export function formatEndDate(endDate: string): string {
  return format(parseISO(endDate), 'MMM dd, yyyy');
}

export function formatDaysRemaining(endDate: string): string {
  const days = getDaysRemaining(endDate);
  
  if (days === 0) return 'Today';
  if (days === 1) return 'Tomorrow';
  if (days > 0) return `${days} days left`;
  if (days === -1) return 'Yesterday';
  return `${Math.abs(days)} days ago`;
}

export function getTodayISO(): string {
  return format(new Date(), 'yyyy-MM-dd');
}
```

### 3. Implement Storage Utilities

**File**: `app/lib/storage.ts`

```typescript
import { Goal } from '@/types/goal';

const STORAGE_KEY = 'doit_goals';

export function loadGoals(): Goal[] {
  try {
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored ? JSON.parse(stored) : [];
  } catch (error) {
    console.error('Failed to load goals:', error);
    return [];
  }
}

export function saveGoals(goals: Goal[]): void {
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(goals));
  } catch (error) {
    console.error('Failed to save goals:', error);
  }
}

export function clearGoals(): void {
  try {
    localStorage.removeItem(STORAGE_KEY);
  } catch (error) {
    console.error('Failed to clear goals:', error);
  }
}
```

### 4. Implement Goal Logic

**File**: `app/lib/goals.ts`

```typescript
import { Goal } from '@/types/goal';
import { getTodayISO } from './dates';
import { parseISO } from 'date-fns';

export function createGoal(title: string, endDate: string): Goal {
  return {
    id: Date.now().toString(),
    title: title.trim(),
    endDate,
    createdDate: getTodayISO(),
    status: 'current',
  };
}

export function isDuplicate(
  title: string,
  endDate: string,
  goals: Goal[]
): boolean {
  return goals.some(
    (g) => g.title === title.trim() && g.endDate === endDate
  );
}

export function isValidEndDate(endDate: string): boolean {
  try {
    const date = parseISO(endDate);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return date >= today;
  } catch {
    return false;
  }
}

export function filterGoalsByStatus(
  goals: Goal[],
  status: 'current' | 'completed'
): Goal[] {
  return goals.filter((g) => g.status === status);
}
```

### 5. Implement localStorage Hook

**File**: `app/hooks/usePersistentGoals.ts`

```typescript
'use client';

import { useEffect, useState } from 'react';
import { Goal } from '@/types/goal';
import { loadGoals, saveGoals } from '@/lib/storage';

export function usePersistentGoals() {
  const [goals, setGoals] = useState<Goal[]>([]);
  const [isLoaded, setIsLoaded] = useState(false);

  // Load from localStorage after hydration
  useEffect(() => {
    const loaded = loadGoals();
    setGoals(loaded);
    setIsLoaded(true);
  }, []);

  // Save to localStorage whenever goals change
  const updateGoals = (newGoals: Goal[]) => {
    setGoals(newGoals);
    saveGoals(newGoals);
  };

  return { goals, setGoals: updateGoals, isLoaded };
}
```

### 6. Implement Goal Management Hook

**File**: `app/hooks/useGoals.ts`

```typescript
'use client';

import { useCallback } from 'react';
import { Goal } from '@/types/goal';
import { usePersistentGoals } from './usePersistentGoals';
import { createGoal, isDuplicate, isValidEndDate } from '@/lib/goals';

export function useGoals() {
  const { goals, setGoals } = usePersistentGoals();

  const addGoal = useCallback(
    (title: string, endDate: string) => {
      // Validation: title
      if (!title.trim()) {
        throw new Error('Title is required');
      }

      // Validation: endDate
      if (!isValidEndDate(endDate)) {
        throw new Error('End date must be today or in the future');
      }

      // Validation: duplicate
      if (isDuplicate(title, endDate, goals)) {
        throw new Error('A goal with this title and date already exists');
      }

      const newGoal = createGoal(title, endDate);
      setGoals([...goals, newGoal]);
      return newGoal;
    },
    [goals, setGoals]
  );

  const completeGoal = useCallback(
    (goalId: string) => {
      setGoals(
        goals.map((g) =>
          g.id === goalId ? { ...g, status: 'completed' as const } : g
        )
      );
    },
    [goals, setGoals]
  );

  const deleteGoal = useCallback(
    (goalId: string) => {
      setGoals(goals.filter((g) => g.id !== goalId));
    },
    [goals, setGoals]
  );

  return { goals, addGoal, completeGoal, deleteGoal };
}
```

---

## Phase 3: Build Components

### 1. Build GoalCard Component

**File**: `components/dashboard/GoalCard.tsx`

```typescript
import React from 'react';
import { Goal } from '@/types/goal';
import { formatDaysRemaining, formatEndDate, isUrgent } from '@/lib/dates';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';

interface GoalCardProps {
  goal: Goal;
  onComplete?: (goal: Goal) => void;
  onDelete?: (goal: Goal) => void;
  showCheckbox?: boolean;
}

export function GoalCard({
  goal,
  onComplete,
  onDelete,
  showCheckbox = false,
}: GoalCardProps) {
  const isGoalUrgent = isUrgent(goal.endDate);
  const daysText = formatDaysRemaining(goal.endDate);
  const dateText = formatEndDate(goal.endDate);

  return (
    <Card
      className={`p-4 ${
        isGoalUrgent
          ? 'bg-pastel-yellow'
          : goal.status === 'completed'
            ? 'bg-pastel-pink'
            : 'bg-white'
      }`}
    >
      <div className="flex items-start gap-3">
        {showCheckbox && (
          <input
            type="checkbox"
            checked={goal.status === 'completed'}
            onChange={() => onComplete?.(goal)}
            className="mt-1 h-5 w-5 accent-pastel-mint"
            aria-label={`Complete: ${goal.title}`}
          />
        )}
        <div className="flex-1">
          <h3
            className={`font-semibold ${
              goal.status === 'completed' ? 'line-through text-gray-500' : ''
            }`}
          >
            {goal.title}
          </h3>
          <p className="text-sm text-gray-600">{daysText}</p>
          <p className="text-xs text-gray-400">{dateText}</p>
        </div>
        {onDelete && (
          <Button
            variant="ghost"
            size="sm"
            onClick={() => onDelete(goal)}
            className="text-red-500 hover:text-red-700"
          >
            Delete
          </Button>
        )}
      </div>
    </Card>
  );
}
```

### 2. Build GoalColumn Component

**File**: `components/dashboard/GoalColumn.tsx`

```typescript
import React from 'react';
import { Goal } from '@/types/goal';
import { GoalCard } from './GoalCard';

interface GoalColumnProps {
  title: 'Current Goals' | 'Completed Goals';
  goals: Goal[];
  onComplete?: (goal: Goal) => void;
  onDelete?: (goal: Goal) => void;
  showCheckbox?: boolean;
}

export function GoalColumn({
  title,
  goals,
  onComplete,
  onDelete,
  showCheckbox = false,
}: GoalColumnProps) {
  return (
    <div className="flex flex-col gap-4">
      <h2 className="text-2xl font-bold text-gray-800">{title}</h2>
      
      {goals.length === 0 ? (
        <div className="rounded-lg border-2 border-dashed border-gray-300 p-8 text-center">
          <p className="text-gray-400">
            {title === 'Current Goals'
              ? 'No goals yet. Add one to get started!'
              : 'No completed goals yet.'}
          </p>
        </div>
      ) : (
        <div className="flex flex-col gap-3">
          {goals.map((goal) => (
            <GoalCard
              key={goal.id}
              goal={goal}
              onComplete={onComplete}
              onDelete={onDelete}
              showCheckbox={showCheckbox}
            />
          ))}
        </div>
      )}
    </div>
  );
}
```

### 3. Build Dashboard Page

**File**: `app/page.tsx`

```typescript
'use client';

import React, { useState } from 'react';
import { DashboardLayout } from '@/components/dashboard/DashboardLayout';

export default function Home() {
  return <DashboardLayout />;
}
```

### 4. Build Layout Component

**File**: `components/dashboard/DashboardLayout.tsx`

```typescript
'use client';

import React, { useState } from 'react';
import { useGoals } from '@/hooks/useGoals';
import { usePersistentGoals } from '@/hooks/usePersistentGoals';
import { filterGoalsByStatus } from '@/lib/goals';
import { Button } from '@/components/ui/button';
import { GoalColumn } from './GoalColumn';
import { AddGoalModal } from '@/components/forms/AddGoalModal';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog';

export function DashboardLayout() {
  const { goals, addGoal, completeGoal, deleteGoal } = useGoals();
  const { isLoaded } = usePersistentGoals();
  
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedGoalForDelete, setSelectedGoalForDelete] = useState<string | null>(null);
  const [formErrors, setFormErrors] = useState<Record<string, string>>({});

  const currentGoals = filterGoalsByStatus(goals, 'current');
  const completedGoals = filterGoalsByStatus(goals, 'completed');

  const handleAddGoal = (title: string, endDate: string) => {
    try {
      setFormErrors({});
      addGoal(title, endDate);
      setIsModalOpen(false);
    } catch (error) {
      if (error instanceof Error) {
        setFormErrors({ submit: error.message });
      }
    }
  };

  const handleDeleteConfirm = (goalId: string) => {
    deleteGoal(goalId);
    setSelectedGoalForDelete(null);
  };

  if (!isLoaded) {
    return <div className="p-8 text-center">Loading...</div>;
  }

  return (
    <div className="min-h-screen bg-neutral-bg p-4 md:p-8">
      <div className="mx-auto max-w-6xl">
        <header className="mb-8">
          <h1 className="text-4xl font-bold text-gray-800">DoIt</h1>
          <p className="text-gray-600">Track your goals and accomplish them</p>
        </header>

        <div className="mb-6">
          <Button
            onClick={() => setIsModalOpen(true)}
            className="btn-primary"
          >
            + Add Goal
          </Button>
        </div>

        <div className="grid gap-8 md:grid-cols-2">
          <GoalColumn
            title="Current Goals"
            goals={currentGoals}
            onComplete={(goal) => completeGoal(goal.id)}
            onDelete={(goal) => setSelectedGoalForDelete(goal.id)}
            showCheckbox={true}
          />
          <GoalColumn
            title="Completed Goals"
            goals={completedGoals}
            onDelete={(goal) => setSelectedGoalForDelete(goal.id)}
            showCheckbox={false}
          />
        </div>

        <AddGoalModal
          open={isModalOpen}
          onClose={() => {
            setIsModalOpen(false);
            setFormErrors({});
          }}
          onSubmit={handleAddGoal}
          errors={formErrors}
        />

        <AlertDialog
          open={selectedGoalForDelete !== null}
          onOpenChange={(open) => {
            if (!open) setSelectedGoalForDelete(null);
          }}
        >
          <AlertDialogContent>
            <AlertDialogHeader>
              <AlertDialogTitle>Delete Goal?</AlertDialogTitle>
              <AlertDialogDescription>
                This action cannot be undone. The goal will be permanently deleted.
              </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
              <AlertDialogCancel>Cancel</AlertDialogCancel>
              <AlertDialogAction
                onClick={() =>
                  selectedGoalForDelete &&
                  handleDeleteConfirm(selectedGoalForDelete)
                }
                className="bg-red-500 hover:bg-red-600"
              >
                Delete
              </AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      </div>
    </div>
  );
}
```

---

## Testing the Implementation

### Manual Testing Checklist

- [ ] App loads without errors
- [ ] Dashboard displays empty state initially
- [ ] "Add Goal" button opens modal
- [ ] Modal form validates empty title (shows error)
- [ ] Modal form validates past dates (shows error)
- [ ] Can create a valid goal (appears in Current Goals)
- [ ] Created goal persists on page reload
- [ ] Checkbox moves goal to Completed Goals
- [ ] Delete button shows confirmation dialog
- [ ] Confirming delete removes goal permanently
- [ ] Layout is responsive on mobile/tablet/desktop
- [ ] All buttons have 44px+ height (mobile)
- [ ] Urgent goals (≤3 days) have pastel yellow background
- [ ] Completed goals have pastel pink background
- [ ] Days remaining text updates correctly
- [ ] No test files created (per constitution)

---

## Development Workflow

### Run Development Server

```bash
npm run dev
# App runs at http://localhost:3000
```

### Build for Production

```bash
npm run build
npm start
```

### Version Control Workflow

```bash
# Daily commits
git add .
git commit -m "feat: implement goal card component"

# After each feature complete
git commit -m "feat: complete Add Goal modal"

# PR workflow (when ready to merge)
git push origin 001-doit-initial-setup
# Create PR on GitHub > review > merge to main
```

---

## Next Steps

1. **Create components** in order: GoalCard → GoalColumn → DashboardLayout → AddGoalModal
2. **Test manually** using checklist above
3. **Commit regularly** after each component is functional
4. **Do NOT create test files** (per constitution)
5. **Manual verification only** via browser testing

---

**Quick Start Status**: ✅ COMPLETE | **Last Updated**: 2026-03-01
