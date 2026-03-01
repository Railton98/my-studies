# Component Contracts: DoIt Initial Page Setup

**Phase**: 1 (Design) | **Date**: 2026-03-01  
**Input**: [data-model.md](../data-model.md) + [research.md](../research.md)

---

## Overview

This document defines the public interface (props, state, callbacks) for all React components in the DoIt dashboard. Following these contracts ensures clean component boundaries and enables independent development.

---

## Layout Components

### DashboardLayout

**File**: `app/page.tsx` or `components/dashboard/DashboardLayout.tsx`

**Purpose**: Container component for the entire dashboard; manages all state and localStorage

**Props**:
```typescript
interface DashboardLayoutProps {
  // No props (root component, manages all state)
}
```

**State**:
```typescript
// Managed via usePersistentGoals hook
const { goals, setGoals, isLoaded } = usePersistentGoals();
// Managed via useState
const [isModalOpen, setIsModalOpen] = useState(false);
const [selectedGoalForDelete, setSelectedGoalForDelete] = useState<Goal | null>(null);
const [isDeleteConfirmOpen, setIsDeleteConfirmOpen] = useState(false);
const [formErrors, setFormErrors] = useState<Record<string, string>>({});
```

**Children**:
- `<GoalColumn title="Current Goals" ... />`
- `<GoalColumn title="Completed Goals" ... />`
- `<AddGoalModal open={isModalOpen} ... />`
- `<AlertDialog open={isDeleteConfirmOpen} ... />`
- Action button for "Add Goal"

**Callbacks**:
- `onAddGoalClick()`: Open modal
- `onGoalComplete(goal)`: Move to completed
- `onGoalDelete(goal)`: Show delete confirmation
- `onConfirmDelete()`: Execute deletion
- `onCancelDelete()`: Close confirmation

**Accessibility**:
- Role: `"main"` for dashboard region
- Semantic heading: `<h1>DoIt Goals</h1>`
- ARIA live region for confirmation dialogs

---

### GoalColumn

**File**: `components/dashboard/GoalColumn.tsx`

**Purpose**: Display a single column (either "Current Goals" or "Completed Goals")

**Props**:
```typescript
interface GoalColumnProps {
  title: "Current Goals" | "Completed Goals";
  goals: Goal[];
  onComplete?: (goal: Goal) => void;
  onDelete?: (goal: Goal) => void;
  onDeleteConfirm?: (goal: Goal) => void;
  isUrgent?: (goal: Goal) => boolean;
}
```

**Example Usage**:
```typescript
<GoalColumn
  title="Current Goals"
  goals={currentGoals}
  onComplete={(goal) => handleComplete(goal)}
  onDelete={(goal) => setSelectedGoalForDelete(goal)}
  isUrgent={(goal) => getDaysRemaining(goal.endDate) <= 3}
/>
```

**Children**:
- `<GoalCard goal={goal} onComplete={onComplete} onDelete={onDelete} />`
- Empty state message if `goals.length === 0`

**Rendering Logic**:
- If no goals: Show placeholder "No goals yet. Add one to get started!"
- If goals exist: Map to GoalCard components
- Current column: Each goal has checkbox and delete button
- Completed column: Each goal has delete button only

**Styling**:
- Container: `bg-neutral-bg` (off-white background)
- Responsive: `col-span-1` on desktop, `col-span-2` stacked on mobile
- Border/shadow: Light border or soft shadow for column separation

**Accessibility**:
- Role: `"region"` with `aria-label={title}`
- Semantic heading: `<h2>{title}</h2>`

---

## Display Components

### GoalCard

**File**: `components/dashboard/GoalCard.tsx`

**Purpose**: Display a single goal with title, deadline, and actions

**Props**:
```typescript
interface GoalCardProps {
  goal: Goal;
  onComplete?: (goal: Goal) => void;
  onDelete?: (goal: Goal) => void;
  isUrgent?: boolean;  // If true, use pastel-yellow background
  showCheckbox?: boolean;  // If true, render checkbox (for current goals)
}
```

**Example Usage**:
```typescript
<GoalCard
  goal={goal}
  onComplete={() => handleComplete(goal)}
  onDelete={() => handleDelete(goal)}
  isUrgent={getDaysRemaining(goal.endDate) <= 3}
  showCheckbox={true}
/>
```

**Rendered Output**:
```
┌─────────────────────────────┐
│ [✓] Learn TypeScript        │ (checkbox only if showCheckbox)
│ 4 days left                 │
│ Mar 05, 2026                │
│                   [Delete]  │ (or [Delete] [Goal] buttons)
└─────────────────────────────┘
```

**Conditional Styling**:
- Urgent (isUrgent): `bg-pastel-yellow` background
- Completed (status="completed"): `bg-pastel-pink` background, strikethrough text
- Normal: White or soft background

**Interactions**:
- Checkbox click: Call `onComplete(goal)`
- Delete button click: Call `onDelete(goal)`
- Goal card click: No navigation (immutable goals)

**Accessibility**:
- Checkbox: Native HTML `<input type="checkbox" />`
- Label: Associated via `htmlFor`
- Button: Semantic `<button>` with clear label

---

## Modal Components

### AddGoalModal

**File**: `components/forms/AddGoalModal.tsx`

**Purpose**: Modal dialog containing the goal creation form

**Props**:
```typescript
interface AddGoalModalProps {
  open: boolean;                           // Modal visibility
  onClose: () => void;                     // Close button or backdrop click
  onSubmit: (title: string, endDate: Date) => void;  // Form submission
  isLoading?: boolean;                     // Disable form while submitting
  errors?: Record<string, string>;         // Validation error messages
}
```

**Example Usage**:
```typescript
<AddGoalModal
  open={isModalOpen}
  onClose={() => setIsModalOpen(false)}
  onSubmit={(title, endDate) => handleAddGoal(title, endDate)}
  isLoading={isSubmitting}
  errors={formErrors}
/>
```

**Structure**:
- Dialog wrapper (shadcn Dialog component)
- Title: "Create New Goal"
- Body: `<GoalForm />` component
- Footer: "Cancel" and "Create" buttons
- Close on backdrop click or close button

**Styling**:
- Overlay: Semi-transparent dark overlay
- Modal: Centered, max-width 400px
- Responsive: Full width on mobile, centered on desktop

**Accessibility**:
- Role: `"dialog"`
- Focus: Trap focus inside modal, return to button on close
- Keyboard: Escape key closes modal
- Label: Modal has `aria-labelledby` to title

---

### GoalForm

**File**: `components/forms/GoalForm.tsx`

**Purpose**: Form inputs for creating/editing goals (title and end date)

**Props**:
```typescript
interface GoalFormProps {
  onSubmit: (title: string, endDate: Date) => void;
  isLoading?: boolean;                     // Disable form during submission
  errors?: Record<string, string>;         // Validation errors: { title?: string, endDate?: string }
  defaultValues?: { title?: string; endDate?: Date };  // For editing (future)
}
```

**Form Fields**:
1. **Title Input**
   - Type: Text input (shadcn Input component)
   - Placeholder: "Goal title (e.g., Learn React)"
   - Validation: Non-empty, max 255 chars
   - Error display: `errors.title` shown below input
   - Max chars indicator: Optional "255 chars max"

2. **End Date Input**
   - Type: Date picker (HTML `<input type="date" />` or shadcn component)
   - Default: Empty (user selects)
   - Validation: Must be today or later, not in past
   - Error display: `errors.endDate` shown below input
   - Hint: "Select a date today or in the future"

**Form Behavior**:
- On mount: Clear/reset form if applicable
- On field change: Clear that field's error message
- On submit: Call `onSubmit(title, endDate)` only if validation passes
- While submitting (isLoading): Disable all inputs and buttons, show spinner

**Validation Rules** (run before onSubmit):
- `title`: Required, non-empty, trimmed, max 255 chars
- `endDate`: Required, not in past (>= today)
- Duplicate check: `onSubmit` handler responsibility (handled in parent)

**Styling**:
- Inputs: Tailwind utilities, alt using shadcn Input
- Labels: Above inputs, bold, semantic `<label>`
- Error text: Pastel red/pink color, small font size
- Submit button: Pastel mint background, 44px+ height for touch

**Accessibility**:
- Labels: Semantic `<label htmlFor={id}>` for each input
- Required: Mark with asterisk and aria-required
- Errors: Associated with inputs via `aria-describedby`
- Submit: Keyboard accessible (Enter or Tab+Space)

---

## Confirmation Dialogs

### DeleteConfirmDialog

**File**: shadcn `AlertDialog` (no custom component, used directly)

**Usage in DashboardLayout**:
```typescript
<AlertDialog open={isDeleteConfirmOpen} onOpenChange={setIsDeleteConfirmOpen}>
  <AlertDialogContent>
    <AlertDialogHeader>
      <AlertDialogTitle>Delete Goal?</AlertDialogTitle>
      <AlertDialogDescription>
        This action cannot be undone. The goal "{selectedGoalForDelete?.title}" will be permanently deleted.
      </AlertDialogDescription>
    </AlertDialogHeader>
    <AlertDialogFooter>
      <AlertDialogCancel onClick={() => setIsDeleteConfirmOpen(false)}>
        Cancel
      </AlertDialogCancel>
      <AlertDialogAction 
        onClick={() => handleConfirmDelete(selectedGoalForDelete)}
        className="bg-red-500"
      >
        Delete
      </AlertDialogAction>
    </AlertDialogFooter>
  </AlertDialogContent>
</AlertDialog>
```

**Props**: Standard shadcn AlertDialog props

**Accessibility**:
- Role: `"alertdialog"`
- Focus: Trapped inside dialog
- Keyboard: Escape cancels, Tab navigates buttons

---

## Utility Hooks Contract

### usePersistentGoals

**File**: `hooks/usePersistentGoals.ts`

**Purpose**: Load goals from localStorage on mount, persist on change

**Interface**:
```typescript
function usePersistentGoals(): {
  goals: Goal[];
  setGoals: (goals: Goal[]) => void;
  isLoaded: boolean;
  error?: string;
}
```

**Behavior**:
- On mount: Load `doit_goals` from localStorage
- Set `isLoaded` to true after load completes
- On `setGoals` call: Update state AND save to localStorage
- If localStorage fails: Log error, continue with in-memory state

**Example**:
```typescript
const { goals, setGoals, isLoaded } = usePersistentGoals();

// Usage:
const newGoals = [...goals, newGoal];
setGoals(newGoals);  // Updates state AND saves to localStorage
```

---

## Styling Conventions

All components use Tailwind CSS with custom @theme colors:

**Color Palette**:
```
--color-pastel-pink: #F8C5D4     (completed goals, success)
--color-pastel-mint: #C0F0E8     (buttons, interactive)
--color-pastel-purple: #E8D4F1   (cards, secondary)
--color-pastel-yellow: #FFF4D4   (urgent goals, warnings)
--color-neutral-bg: #FAFAF8      (backgrounds, off-white)
```

**Responsive Breakpoints**:
- Mobile: 375px default, `sm:` for 640px
- Tablet: `md:` for 768px
- Desktop: `lg:` for 1024px, `xl:` for 1280px

**Component Sizes**:
- Buttons/inputs: 44px minimum height (touch friendly)
- Spacing: Use p-4, m-4 (16px), p-2, m-2 (8px)
- Text: Base 16px, sm: 14px, lg: 18px

---

**Contract Status**: ✅ FINALIZED | **Validation**: Complete | **Date**: 2026-03-01
