# Data Model: DoIt Initial Page Setup

**Phase**: 1 (Design) | **Date**: 2026-03-01  
**Input**: [spec.md](spec.md) + [research.md](research.md)

---

## Entity: Goal

**Purpose**: Represents a user's objective with a deadline

**TypeScript Definition**:
```typescript
interface Goal {
  id: string;               // Unique identifier (timestamp or UUID)
  title: string;            // Goal title (required, 1-255 chars)
  endDate: string;          // ISO 8601 date (YYYY-MM-DD format)
  createdDate: string;      // ISO 8601 date (YYYY-MM-DD format)
  status: "current" | "completed"; // Current or completed state
}
```

### Attributes

| Attribute | Type | Required | Constraints | Purpose |
|-----------|------|----------|-----------|---------|
| `id` | string | Yes | Unique, immutable | Unique goal identifier; used for delete/update |
| `title` | string | Yes | 1-255 chars, non-empty (trimmed) | User-displayable goal name |
| `endDate` | string | Yes | ISO 8601 (YYYY-MM-DD), >= today | Target completion date |
| `createdDate` | string | Yes | ISO 8601 (YYYY-MM-DD) | Audit trail; when goal was created |
| `status` | enum | Yes | "current" \| "completed" | Determines column placement |

### Computed Properties (not stored)

These are derived from the Goal and re-calculated on every access:

```typescript
interface GoalWithComputed extends Goal {
  daysRemaining: number;    // differenceInDays(endDate, today)
  isUrgent: boolean;        // daysRemaining <= 3 && daysRemaining >= 0
  displayDays: string;      // "3 days left" | "Today" | "Tomorrow" | "Overdue"
  displayDate: string;      // "Mar 05, 2026" formatted
}
```

### Validation Rules

**On Creation**:
1. `title` must be non-empty after trim (FR-005)
2. `endDate` must not be in the past (FR-005)
3. No goal can exist with same (title, endDate) combination (FR-005, Clarification Q2)

**On State Change**:
- `status` change: "current" → "completed" via checkbox (FR-006)
- Deletion: Only from localStorage (FR-007)
- Immutability: Title/endDate cannot be edited (Clarification Q3)

**Storage Constraint**:
- JSON stringification: must be reversible
- endDate must be valid ISO date parseable by `new Date(endDate)`
- No circular references or special objects

---

## State Model: GoalsState

**Purpose**: Manages application state for goal management

```typescript
interface GoalsState {
  // Core data
  goals: Goal[];                        // All goals (current + completed)
  isLoaded: boolean;                    // Has localStorage been read?
  
  // UI State
  isModalOpen: boolean;                 // Add Goal modal visibility
  selectedGoalForDelete: Goal | null;   // Delete confirmation dialog
  isDeleteConfirmDialogOpen: boolean;   // Delete confirmation visibility
  
  // Form State
  formErrors: Record<string, string>;   // Field validation errors
  isSubmitting: boolean;                // Form submission in progress
}
```

### State Transitions

```
Initial State:
{
  goals: [],
  isLoaded: false,
  isModalOpen: false,
  selectedGoalForDelete: null,
  isDeleteConfirmDialogOpen: false,
  formErrors: {},
  isSubmitting: false
}

After localStorage load:
{
  goals: [...],            // Loaded from storage
  isLoaded: true,
  ...rest unchanged
}

When "Add Goal" clicked:
{
  ...same,
  isModalOpen: true,
}

When form submitted (valid):
{
  goals: [..., newGoal],   // Added
  isModalOpen: false,
  formErrors: {},
  ...rest
}

When checkbox clicked on goal:
{
  goals: [goal.status = "completed"],  // Status updated
  ...rest
}

When delete button clicked:
{
  selectedGoalForDelete: goal,
  isDeleteConfirmDialogOpen: true,
  ...rest
}

When delete confirmed:
{
  goals: goals.filter(g => g.id !== selectedGoal.id),
  selectedGoalForDelete: null,
  isDeleteConfirmDialogOpen: false,
  ...rest
}
```

---

## localStorage Schema

**Storage Key**: `doit_goals`

**Format**: JSON array of Goal objects

```json
[
  {
    "id": "1709337600000",
    "title": "Learn TypeScript",
    "endDate": "2026-04-01",
    "createdDate": "2026-03-01",
    "status": "current"
  },
  {
    "id": "1709337700000",
    "title": "Build portfolio site",
    "endDate": "2026-05-15",
    "createdDate": "2026-03-01",
    "status": "current"
  },
  {
    "id": "1709337800000",
    "title": "Complete React course",
    "endDate": "2026-02-28",
    "createdDate": "2026-02-01",
    "status": "completed"
  }
]
```

**Size Estimates**:
- Per goal: ~200 bytes (title + dates + overhead)
- Safe limit: 500-1000 goals (~100-200 KB)
- localStorage total capacity: 5-10 MB (easily sufficient for MVP)

**Serialization**:
- Save: `JSON.stringify(goals)`
- Load: `JSON.parse(localStorage.getItem('doit_goals')) as Goal[]`
- Error handling: If parse fails or corrupted, start with empty array

---

## Relationships

**No foreign keys or joins** — All data is contained within the Goal entity.

**Derived Relationships**:
- Goals are filtered into two groups: `currentGoals` (status="current") and `completedGoals` (status="completed")
- No hierarchical or relational structure

---

## Lifecycle

### Goal Creation
1. User fills modal form (title, endDate)
2. System validates (non-empty, future date, no duplicate)
3. System generates `id` and `createdDate`
4. Goal added to `goals[]` with status="current"
5. Saved to localStorage
6. Modal closes

### Goal Completion
1. User checks checkbox on goal in current column
2. System updates goal's `status` to "completed"
3. Goal moves to completed column (visual update)
4. Saved to localStorage

### Goal Deletion
1. User clicks delete button
2. System shows confirmation dialog (if in current column) or deletes directly (if in completed)
3. If confirmed: Goal removed from `goals[]`
4. Saved to localStorage

---

## Migration / Evolution

**If moving to backend later**:
- Replace `usePersistentGoals` hook with API calls (`GET /api/goals`, `POST /api/goals`, etc.)
- Same Goal interface/types (no UI changes needed)
- Add `userId` field to Goal entity
- Add server-side validation and auth

**Backward compatibility**:
- Current schema is simple enough to evolve
- Versioning: If schema changes, add `schemaVersion` field to root

---

## Performance Considerations

**Read Performance**:
- localStorage read: synchronous, <10ms even with 1000 goals
- Filtering (current vs completed): O(n), fast for <1000 goals
- Sorting: Can be added later if needed

**Write Performance**:
- JSON.stringify and localStorage.setItem: synchronous, <5ms for 1000 goals
- No N+1 queries (single localStorage operation per action)

**Calculated Properties**:
- daysRemaining: O(1), calculated on demand in components
- isUrgent: O(1), depends only on daysRemaining
- No expensive queries or algorithms

---

**Schema Status**: ✅ FINALIZED | **Validation**: Complete | **Date**: 2026-03-01
