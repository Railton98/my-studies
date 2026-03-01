# Implementation Plan: DoIt Initial Page Setup

**Branch**: `001-doit-initial-setup` | **Date**: 2026-03-01 | **Spec**: [spec.md](spec.md)  
**Input**: Feature specification from `/specs/001-doit-initial-setup/spec.md`

## Summary

Build the DoIt MVP dashboard—a two-column goal tracking interface with:
- **Left column**: Current goals with deadline urgency indicators (within 3 days highlighted in pastel yellow)
- **Right column**: Completed goals
- **Add Goal button**: Modal form to create new goals (title + end date, with duplicate prevention)
- **Interactions**: Checkbox to complete goals, delete buttons with confirmation
- **Data**: Persisted in browser localStorage, loaded on page load
- **Design**: Modern light theme using Classic Pastels (pink, mint, purple, yellow)
- **Responsive**: Mobile-first layout (stacked columns on mobile, side-by-side on desktop)

---

## Technical Context

**Language/Version**: TypeScript 5+ (per Next.js 16.1.6 requirement)  
**Primary Dependencies**: 
- **UI**: shadcn/ui (React component library)
- **Styling**: Tailwind CSS 4 with @theme color customization (pastel palette)
- **Date handling**: date-fns (for deadline calculations and formatting)
- **State**: React hooks (useState, useEffect) for local component state
- **Storage**: Browser localStorage API (via custom React hook)

**Storage**: Browser localStorage (JSON serialization) — single-user, offline-capable, no backend  
**Testing**: ZERO (per constitution) — no unit, integration, or e2e tests  
**Target Platform**: Web browsers (modern, ES2020+), mobile-responsive  
**Project Type**: Next.js 16 web application (App Router), frontend-only MVP  
**Performance Goals**: <2s load time (including localStorage read), instant interactions  
**Constraints**: 
- No external API calls (offline-first)
- No user authentication (single-user local app)
- No multi-tab sync (localStorage read once on load)
- Goals immutable after creation (delete/recreate pattern only)

**Scale/Scope**: 
- MVP scope: 4 user stories, ~3-5 React components
- Estimated goals: thousands (localStorage limit ~5-10MB, each goal ~200 bytes)
- Single user, no concurrent sessions

---

## Constitution Check

### Core Principles Alignment

✅ **I. Clean Code**
- Small, focused components (Goal card, Modal, Dashboard layout)
- Descriptive function names (`usePersistentGoals`, `calculateDaysRemaining`, `isUrgent`)
- No implementation complexity; straightforward logic

✅ **II. Simple UX**
- Two-column layout with clear hierarchy
- Single primary action per view (Add Goal button, complete/delete buttons)
- Immediate visual feedback (goal moves/disappears)
- No unnecessary controls or options

✅ **III. Responsive Design**
- Mobile-first approach: stack columns vertically, adapt typography
- Tailwind responsive utilities (`md:` breakpoints)
- 44px+ touch targets for all buttons
- Tested across 375px, 768px, 1920px+ widths

✅ **IV. Minimal Dependencies**
- shadcn/ui justified: Pre-styled components save dev time, not overkill
- date-fns justified: Date arithmetic (days remaining) is non-trivial
- Tailwind @theme justified: Pinned in constitution, required for theme colors
- localStorage is built-in; no extra package needed

### Zero Testing Policy

✅ **NO VIOLATIONS**: No test files, frameworks, or runners in scope. Manual verification only.

**GATE RESULT**: ✅ **CLEAR** — No constitutional violations. All principles satisfied.

---

## Project Structure

### Documentation (this feature)

```text
specs/001-doit-initial-setup/
├── spec.md              # Feature specification ✅ (done)
├── plan.md              # This file
├── research.md          # Phase 0 output (research into tech patterns)
├── data-model.md        # Phase 1 output (entity definitions)
├── quickstart.md        # Phase 1 output (setup instructions)
├── contracts/           # Phase 1 output (component interfaces)
└── checklists/
    ├── requirements.md
    └── clarification-session.md
```

### Source Code (repository root — Next.js App Router structure)

```text
doit_speckit/
├── app/
│   ├── page.tsx                 # Main dashboard page
│   ├── layout.tsx               # Root layout (updated)
│   └── globals.css              # Tailwind @theme customization
├── components/
│   ├── dashboard/
│   │   ├── DashboardLayout.tsx  # Two-column layout wrapper
│   │   ├── GoalColumn.tsx       # Current/Completed goals column
│   │   └── GoalCard.tsx         # Individual goal display
│   ├── forms/
│   │   ├── AddGoalModal.tsx     # Modal form for new goal
│   │   └── GoalForm.tsx         # Form inputs (title, date)
│   └── common/
│       ├── Button.tsx           # shadcn Button wrapper
│       ├── Input.tsx            # shadcn Input wrapper
│       ├── Dialog.tsx           # shadcn Dialog wrapper (Modal)
│       └── AlertDialog.tsx      # shadcn AlertDialog wrapper (Delete confirmation)
├── hooks/
│   ├── usePersistentGoals.ts    # localStorage persistence hook
│   └── useGoals.ts              # Goal management hook (add, complete, delete)
├── lib/
│   ├── goals.ts                 # Goal entity logic
│   ├── storage.ts               # localStorage utils
│   └── dates.ts                 # date-fns utilities (days remaining, formatting)
└── types/
    └── goal.ts                  # TypeScript types/interfaces
```

**Structure Decision**: Single project with app/ and components/ folders (Next.js App Router standard). No separate backend (localStorage API). No tests/ directory.

---

## Complexity Tracking

No constitutional violations requiring justification. All dependencies justified above.

---

## Phase 0: Research — Resolved Questions

### Technology Integration Patterns

**Q1: How to use Tailwind @theme for dynamic pastel palette?**
- **Research**: Tailwind CSS 4 supports `@theme` directive in CSS for color customization
- **Pattern**: Define custom colors in `globals.css` using `@theme { --color-... }` block
- **Integration**: Reference via `bg-pastel-pink`, `border-pastel-mint`, etc. in component classes
- **Reference**: [Tailwind Theming Docs](https://tailwindcss.com/docs/theme)

**Q2: Best practice for localStorage with React (hydration safety)?**
- **Research**: localStorage is synchronous but unavailable during SSR (server-side rendering)
- **Pattern**: Custom hook (`usePersistentGoals`) that checks `typeof window !== 'undefined'` before accessing localStorage
- **Integration**: Use hook in components to safely read/write goals
- **Anti-pattern**: Don't access localStorage directly in component body; use hooks/effects

**Q3: Date arithmetic with date-fns (calculate days remaining)?**
- **Research**: date-fns provides `differenceInDays()` and `formatDistanceToNow()` functions
- **Pattern**: Helper function in `lib/dates.ts`: `getDaysRemaining(endDate: Date) => number`
- **Integration**: Call in GoalCard component to display "X days left" text
- **Reference**: [date-fns API](https://date-fns.org/docs/differenceInDays)

**Q4: shadcn/ui component composition with custom styling?**
- **Research**: shadcn components accept `className` prop for Tailwind customization
- **Pattern**: Wrap shadcn Button/Dialog/Input components, pass pastel color Tailwind classes
- **Integration**: E.g., `<Button className="bg-pastel-mint hover:bg-pastel-mint/80">Add Goal</Button>`
- **Benefit**: Pre-built a11y, no style reinvention

**Q5: Duplicate goal validation (title + date hash)?**
- **Research**: Simple approach: iterate goals list, check if any goal has same `title` AND `endDate`
- **Pattern**: Function `isDuplicateGoal(title, endDate, existingGoals) => boolean`
- **Integration**: Call during form submission; show error message if duplicate found
- **Storage**: Goals stored as JSON array in localStorage with full goal objects

### Conclusion

All technologies integrate cleanly without conflicts. Zero testing required per constitution. Ready for Phase 1 design.

---

## Phase 1: Design & Contracts

### Data Model

(Detailed in [data-model.md](data-model.md))

**Goal Entity**:
```typescript
interface Goal {
  id: string;                    // UUID or timestamp
  title: string;                 // Goal title (non-empty, unique per date)
  endDate: Date;                 // Target completion date
  createdDate: Date;             // When goal was created
  status: "current" | "completed"; // Goal status
}

// Derived/computed properties (not stored):
// - daysRemaining: number (differenceInDays(endDate, today))
// - isUrgent: boolean (daysRemaining <= 3)
// - displayDate: string (formatted date string)
```

**App State**:
```typescript
interface GoalsState {
  goals: Goal[];                 // All goals (current + completed)
  selectedGoalForDelete: Goal | null; // For delete confirmation dialog
  modalOpen: boolean;            // Add goal modal visibility
  formErrors: { [key: string]: string }; // Form validation errors
}
```

### Component API / Contracts

(Detailed in [contracts/components.md](contracts/components.md))

**DashboardLayout.tsx**
```typescript
// Props: none (self-managed, loads from storage)
// State: manages goals array, modal state, delete confirmation
// Exports: main app layout
```

**GoalColumn.tsx**
```typescript
interface GoalColumnProps {
  title: "Current Goals" | "Completed Goals";
  goals: Goal[];
  onComplete?: (goal: Goal) => void;    // For current goals
  onDelete?: (goal: Goal) => void;
  onDeleteConfirm?: (goal: Goal) => void;
  isLoading?: boolean;
}
```

**GoalCard.tsx**
```typescript
interface GoalCardProps {
  goal: Goal;
  onComplete?: (goal: Goal) => void;
  onDelete?: (goal: Goal) => void;
  isUrgent?: boolean;
}
// Renders: goal title, days remaining, checkbox/delete button
// Highlight: pastel yellow background if isUrgent
```

**AddGoalModal.tsx**
```typescript
interface AddGoalModalProps {
  open: boolean;
  onClose: () => void;
  onSubmit: (title: string, endDate: Date) => void;
  isLoading?: boolean;
  errors?: { [key: string]: string };
}
// Renders: modal dialog with GoalForm inside
```

**GoalForm.tsx**
```typescript
interface GoalFormProps {
  onSubmit: (title: string, endDate: Date) => void;
  isLoading?: boolean;
  errors?: { [key: string]: string };
}
// Fields: title (text input), endDate (date picker)
// Validation: title not empty, endDate not in past, no duplicates
```

### Quick Start

(Detailed in [quickstart.md](quickstart.md))

**Setup**:
1. Install dependencies: `npm install date-fns`
2. Ensure shadcn/ui components installed (Button, Dialog, Input, AlertDialog, Card)
3. Configure Tailwind @theme in `globals.css` with pastel colors
4. Create components in `components/` following structure above

**Initial Development**:
1. Start with GoalCard display component (no interactivity)
2. Add localStorage hook and load goals into state
3. Build DashboardLayout layout
4. Implement delete functionality with confirmation dialog
5. Implement complete (checkbox) functionality
6. Build AddGoalModal and form validation
7. Test all flows manually on mobile/desktop

**Color Palette (Tailwind @theme)**:
```css
@theme {
  --color-pastel-pink: #F8C5D4;
  --color-pastel-mint: #C0F0E8;
  --color-pastel-purple: #E8D4F1;
  --color-pastel-yellow: #FFF4D4;
  --color-neutral-bg: #FAFAF8;
}
```

---

**Version**: 1.0.0-Plan | **Created**: 2026-03-01 | **Status**: Ready for Implementation
