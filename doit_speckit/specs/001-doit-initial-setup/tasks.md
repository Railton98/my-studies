# Tasks: DoIt Initial Page Setup

**Input**: Design documents from `/specs/001-doit-initial-setup/`  
**Prerequisites**: plan.md (✅ done), spec.md (✅ done), research.md (✅ done), data-model.md (✅ done), contracts/components.md (✅ done)  
**Branch**: `001-doit-initial-setup`  
**Status**: Ready for Implementation  

**Note**: Per DoIt Constitution, NO unit tests, integration tests, or e2e tests. All quality assurance via manual browser testing only.

---

## Organization

Tasks are grouped by **user story** to enable independent implementation and manual verification. Each story builds on foundational infrastructure (Phase 1-2) but can be implemented separately.

**User Story Priority Order**:
- **P1 - View Dashboard**: MVP foundation (must complete first)
- **P2 - Add Goal**: MVP extension (depends on P1)
- **P3 - Complete/Delete Goal**: Goal management
- **P3b - Urgent Highlighting**: Visual enhancement

**Format**: `- [ ] T### [P?] [Story?] Description with file path`
- **[P]**: Parallelizable (different files, no dependencies)
- **[Story]**: User story ID (US1, US2, US3, US3b)

---

## Phase 1: Setup & Infrastructure

**Purpose**: Project initialization and environment configuration

- [ ] T001 Install dependencies: `npm install date-fns` in repository root
- [ ] T002 Install shadcn/ui components: `npx shadcn-ui@latest add button input card dialog alert-dialog` in app directory
- [ ] T003 Verify Tailwind CSS 4 configuration: check `postcss.config.mjs` includes `@tailwindcss/postcss`
- [ ] T004 Create project directory structure: `components/dashboard/`, `components/forms/`, `hooks/`, `lib/`, `types/` directories
- [ ] T005 [P] Create TypeScript types file at `types/goal.ts` with Goal interface and GoalsState interface

---

## Phase 2: Foundational Infrastructure

**Purpose**: Shared utilities and hooks that enable all user stories

These tasks must complete before Phase 3. Multiple tasks can run in parallel.

- [ ] T006 [P] Create `lib/dates.ts`: Implement `getDaysRemaining()`, `isUrgent()`, `formatDaysRemaining()`, `formatEndDate()` functions using date-fns
- [ ] T007 [P] Create `lib/storage.ts`: Implement `loadGoals()`, `saveGoals()`, `clearGoals()` localStorage wrapper functions
- [ ] T008 [P] Create `lib/goals.ts`: Implement `createGoal()`, `isDuplicateGoal()`, `isValidEndDate()`, `filterGoalsByStatus()` business logic functions
- [ ] T009 [P] Create `hooks/usePersistentGoals.ts`: Implement custom hook with localStorage read on mount and save on change (handle hydration safely)
- [ ] T010 [P] Create `hooks/useGoals.ts`: Implement custom hook with methods `addGoal()`, `completeGoal()`, `deleteGoal()`, and validation
- [ ] T011 Create `app/globals.css`: Add Tailwind `@theme` directive with pastel colors (pink #F8C5D4, mint #C0F0E8, purple #E8D4F1, yellow #FFF4D4)

---

## Phase 3: User Story 1 - View Dashboard [US1]

**Goal**: User lands on app and sees two-column dashboard with current and completed goals (P1 priority)

**Manual Verification**:
- Empty state shows helpful placeholder text in both columns
- Navigate to 3 current goals + 2 completed goals scenario locally
- Verify responsive layout on mobile (375px), tablet (768px), desktop (1920px+)
- Each goal displays title and days remaining correctly

**Tasks**:

- [ ] T012 [US1] Create `components/dashboard/GoalCard.tsx`: Display individual goal with title, days remaining text, checkbox/delete button, urgent highlighting styling
- [ ] T013 [US1] Create `components/dashboard/GoalColumn.tsx`: Display column header with GoalCard list, render empty state if no goals
- [ ] T014 [US1] Create `components/dashboard/DashboardLayout.tsx`: Container component with two GoalColumn instances, manage all app state (goals, modals, errors)
- [ ] T015 [US1] Create `app/page.tsx`: Import and render DashboardLayout component, initialize usePersistentGoals hook on mount
- [ ] T016 [US1] Implement localStorage loading: DashboardLayout reads goals from `doit_goals` key on first render, displays loading state while loading
- [ ] T017 [US1] Implement responsive layout: Use Tailwind breakpoints (md:flex-row on tablet+) to display columns side-by-side on desktop, stacked on mobile
- [ ] T018 [US1] Implement empty state messaging: Show "No goals yet. Click 'Add Goal' to get started!" when columns are empty
- [ ] T019 [US1] Implement days remaining display: Calculate and format using `formatDaysRemaining()` from lib/dates.ts (e.g., "3 days left", "Today", "Tomorrow", "Overdue")

**Parallel Opportunities**:
- T012-T013 can be implemented in parallel (independent components)
- T014-T015 depend on T012-T013, start after those complete

**MVP Stop Point**: After this phase, user can view dashboard (even if empty). This satisfies SC-001 (user understands app purpose in <10s).

---

## Phase 4: User Story 2 - Add Goal [US2]

**Goal**: User clicks button to open modal form and create goal (P2 priority, depends on US1)

**Manual Verification**:
- Click "Add Goal" button opens modal
- Modal has text input for title and date picker for end date
- Submit with valid inputs creates goal visible in current column within 1-2 seconds
- Validation prevents submission: empty title, past date, duplicate goal
- Show error messages on form (e.g., "Title is required", "Goal already exists")
- Close button or clicking outside modal closes without creating

**Tasks**:

- [ ] T020 [US2] Create `components/forms/GoalForm.tsx`: Render title input, end date picker, submit/cancel buttons with error display
- [ ] T021 [US2] Create `components/forms/AddGoalModal.tsx`: Wrap GoalForm in shadcn Dialog modal with title and header
- [ ] T022 [US2] Implement "Add Goal" button in DashboardLayout: Set `isModalOpen` state when clicked
- [ ] T023 [US2] Implement form validation: Check empty title, future date, duplicate goal before submission
- [ ] T024 [US2] Implement form submission: Call `useGoals.addGoal()` hook with title and date, clear form errors on success, close modal
- [ ] T025 [US2] Implement form error handling: Display validation error messages under relevant fields (title field, date field, or general)
- [ ] T026 [US2] Implement modal close: Add close button and clicking-outside behavior to set `isModalOpen` to false
- [ ] T027 [US2] Implement success feedback: Goal appears in current goals column immediately after creation (within 1-2 seconds network delay)

**Parallel Opportunities**:
- T020-T021 can start in parallel (different components)
- T022-T026 depend on T020-T021

**MVP Stop Point**: After this phase, user can view dashboard AND create new goals. This satisfies SC-002 (create goal in <30s) and SC-003 (instant move to completed).

---

## Phase 5: User Story 3 - Complete and Delete Goals [US3]

**Goal**: User can check goal checkbox to complete or delete goals with confirmation (P3 priority, depends on US1)

**Manual Verification**:
- Checkbox on current goal moves it to completed column instantly
- Delete button shows confirmation dialog before permanent deletion
- Confirm and cancel buttons work correctly on confirmation dialog
- Completed goals have delete button (checkbox removed)
- Deleted goals disappear from dashboard permanently
- Goals persist after page reload (localStorage saves state)

**Tasks**:

- [ ] T028 [US3] Create confirmation dialog component: Use shadcn AlertDialog for delete confirmation with "Delete" and "Cancel" buttons
- [ ] T029 [US3] Implement checkbox interaction: When checkbox clicked on current goal, call `useGoals.completeGoal()` to update status to "completed"
- [ ] T030 [US3] Implement delete button (current column): Show delete confirmation dialog when clicked (set selectedGoalForDelete state)
- [ ] T031 [US3] Implement delete confirmation dialog: Display goal title, show "This action cannot be undone" warning
- [ ] T032 [US3] Implement delete confirmation actions: "Delete" button calls `useGoals.deleteGoal()`, "Cancel" closes dialog without deleting
- [ ] T033 [US3] Implement delete button (completed column): Delete directly with confirmation (same as current column)
- [ ] T034 [US3] Implement localStorage persistence: Save goals array to localStorage after each add/complete/delete operation
- [ ] T035 [US3] Verify hydration safety: Ensure localStorage access only happens in useEffect with `typeof window !== 'undefined'` check

**Parallel Opportunities**:
- T028-T029 can start in parallel (independent implementations)
- T030-T033 depend on T028-T029
- T034-T035 can run in parallel with other completion tasks

**Feature Complete Point**: After this phase, user can manage full goal lifecycle (view, add, complete, delete). MVP is fully functional.

---

## Phase 6: User Story 3b - Urgent Highlighting [US3b]

**Goal**: Goals within 3 days of deadline are visually highlighted (P3 priority, depends on US1)

**Manual Verification**:
- Create goal ending 2 days from today → highlighted with pastel yellow background
- Create goal ending 5 days from today → NOT highlighted
- Highlighting updates correctly when day changes (simulate with mock date)
- Goal ending today (0 days) is highlighted as urgent
- Overdue goals (negative days) are highlighted or marked "Overdue"

**Tasks**:

- [ ] T036 [US3b] Implement urgency display in GoalCard: Call `isUrgent()` function from lib/dates.ts to determine highlighting
- [ ] T037 [US3b] Implement urgent styling: Add Tailwind class to GoalCard background when `isUrgent()` returns true (e.g., `bg-pastel-yellow`)
- [ ] T038 [US3b] Implement days remaining styling: Show different text color/weight for urgent goals (darker text on yellow background)
- [ ] T039 [US3b] Implement urgent label: Show "(Urgent)" text or icon next to days remaining for goals within 3 days
- [ ] T040 [US3b] Test urgency calculations: Verify getDaysRemaining() returns correct values for various end dates

**Parallel Opportunities**:
- T036-T037 can run in parallel (styling and logic)

---

## Phase 7: Configuration & Styling

**Purpose**: Apply design system and finalize responsive layout

- [ ] T041 [P] Configure Tailwind color utilities: Ensure `bg-pastel-*`, `text-pastel-*` classes work correctly in components
- [ ] T042 [P] Set button styling: 44px+ height on mobile, hover states using pastel colors
- [ ] T043 [P] Set input/date picker styling: Consistent with pastels, at least 44px height on mobile
- [ ] T044 [P] Implement focus states: All interactive elements have visible focus for accessibility (44px touch targets minimum)
- [ ] T045 [P] Test responsive breakpoints: Verify layout adapts correctly at 375px, 768px, 1920px+ widths
- [ ] T046 Create `app/layout.tsx`: Apply globals.css, set page title "DoIt - Goal Tracker", ensure root layout wraps app correctly

---

## Phase 8: Manual Testing & Verification

**Purpose**: Validate all functionality per success criteria (NO automated tests per constitution)

### Manual Test Checklist

- [ ] T047 Test on mobile (375px width): All buttons clickable, columns stack vertically, text readable, no overflow
- [ ] T048 Test on tablet (768px width): Columns display side-by-side or stacked based on design, responsive padding/margins
- [ ] T049 Test on desktop (1920px width): Two columns side-by-side with max-width constraints, good spacing
- [ ] T050 Test empty state: Load app first time, verify both columns show "No goals yet..." message
- [ ] T051 Test goal creation flow: Click Add Goal → Fill form → Submit → Goal appears in current column (< 30 seconds total)
- [ ] T052 Test form validation: Try submit with empty title → Error shown; Try past date → Error shown; Try duplicate → Error shown
- [ ] T053 Test goal completion: Click checkbox on current goal → Goal moves to completed column (instant)
- [ ] T054 Test goal deletion: Click delete → Confirmation dialog shown → Confirm → Goal removed; Cancel → Dialog closes without deleting
- [ ] T055 Test urgent highlighting: Create goal ending in 2 days → Highlighted in yellow; Create goal in 5 days → Not highlighted
- [ ] T056 Test persistence: Add 3 goals → Reload page → All 3 goals still present in localStorage
- [ ] T057 Test accessibility: Tab through elements, verify focus visible on all buttons; Check color contrast (WCAG AA minimum)
- [ ] T058 Verify no test files: Confirm no `__tests__/`, `.test.ts`, `.spec.ts`, or `jest.config.js` files exist
- [ ] T059 Test date formatting: Goal ending today shows "Today"; Tomorrow shows "Tomorrow"; 3 days away shows "3 days left"
- [ ] T060 Test localStorage limits: Add >100 goals (if feasible), verify app doesn't crash or lose data

---

## Phase 9: Polish & Git Workflow

**Purpose**: Final cleanup and version control

- [ ] T061 Review code for clean code principle: Descriptive names, small components, no commented code
- [ ] T062 Review code for simple UX principle: No redundant controls, clear hierarchy, single primary action per screen
- [ ] T063 Verify minimal dependencies: Only date-fns, shadcn/ui, Tailwind in dependencies; no unnecessary packages
- [ ] T064 Add meaningful comments: Document non-obvious logic (e.g., hydration check, duplicate detection)
- [ ] T065 Format code: Run prettier/ESLint if configured (ensure consistency)
- [ ] T066 [P] Commit setup and infrastructure: `git add app/globals.css hooks/lib/types package.json && git commit -m "build: configure tailwind theme and install dependencies"`
- [ ] T067 [P] Commit Phase 3 components: `git add components/dashboard/ && git commit -m "feat(US1): dashboard view with goal columns"`
- [ ] T068 [P] Commit Phase 4 components: `git add components/forms/ && git commit -m "feat(US2): add goal form and modal"`
- [ ] T069 [P] Commit Phase 5 features: `git add hooks/useGoals.ts && git commit -m "feat(US3): goal completion and deletion with confirmation"`
- [ ] T070 [P] Commit Phase 6 styling: `git add components/dashboard/GoalCard.tsx && git commit -m "feat(US3b): urgent deadline highlighting"`
- [ ] T071 Create pull request: Push to origin `001-doit-initial-setup` branch, create PR to `main` with description of all 4 user stories

---

## Task Summary

**Total Tasks**: 71 (T001-T071)

**By Phase**:
- Phase 1 Setup: 5 tasks (T001-T005)
- Phase 2 Infrastructure: 6 tasks (T006-T011)
- Phase 3 US1 View Dashboard: 8 tasks (T012-T019)
- Phase 4 US2 Add Goal: 8 tasks (T020-T027)
- Phase 5 US3 Complete/Delete: 8 tasks (T028-T035)
- Phase 6 US3b Highlighting: 5 tasks (T036-T040)
- Phase 7 Styling: 6 tasks (T041-T046)
- Phase 8 Manual Testing: 14 tasks (T047-T060)
- Phase 9 Polish & Git: 7 tasks (T061-T071)

**Parallelizable Tasks** (can run simultaneously):
- **T001-T003**: Dependencies and configuration (all independent)
- **T006-T010**: Utilities and hooks (all in different files)
- **T041-T045**: Styling configuration (all independent)
- **T066-T070**: Git commits (sequential, but organize after each phase)

**Dependencies**:
- T001-T005 must complete before T006
- T006-T011 must complete before T012
- T012-T019 must complete before T020 (US2 depends on US1)
- T020-T027 must complete before T028 (US3 depends on US2)
- T036-T040 can run in parallel with T028-T035 (independent styling)

**MVP Scope** (Minimum to ship):
- Phases 1-3 (Setup + US1 View Dashboard) delivers basic functioning app
- Phases 1-4 (Setup + US1-US2) delivers full MVP with goal creation
- Phases 1-5 (Setup + US1-US3) deliver complete goal management feature
- Phases 1-6 (Setup + US1-US3b) deliver polished, feature-complete DoIt app

**Estimated Effort**:
- Phase 1-2: 1.5-2 hours (setup, shared utilities)
- Phase 3: 2-3 hours (dashboard display)
- Phase 4: 1.5-2 hours (form inputs and validation)
- Phase 5: 1-1.5 hours (delete flow, state management)
- Phase 6: 0.5-1 hour (styling for urgency)
- Phase 7: 1 hour (responsive styling)
- Phase 8: 1-2 hours (manual testing all scenarios)
- Phase 9: 0.5-1 hour (cleanup and git)

**Total MVP**: **9-14 hours** intensive work (1-2 day sprint)

---

## Implementation Order (Recommended)

**Day 1 Start**:
1. Start T001-T005 (Setup) in parallel
2. Start T006-T011 (Infrastructure) once dependencies installed
3. Start T012-T019 (US1 Dashboard) once hooks ready

**Day 1 Afternoon**:
4. Pause for manual testing of US1 (T047-T050)
5. If US1 passes, continue with T020-T027 (US2 Add Goal)

**Day 2**:
6. Test US2 flow (T051-T059)
7. Implement T028-T035 (US3 Complete/Delete)
8. Test full flow (T047-T060)
9. Implement T036-T040 (US3b Highlighting)
10. Run full manual testing suite (T047-T060 again)
11. Polish and commit (T061-T071)

---

## Success Criteria Mapping

Each success criterion from spec.md is validated by manual testing tasks:

| SC # | Criterion | Testing Tasks |
|------|-----------|---------------|
| SC-001 | Understand app in <10s | T050 (empty state), T049 (desktop layout) |
| SC-002 | Create goal <30s | T051 (creation flow) |
| SC-003 | Complete with 1 click | T053 (checkbox action) |
| SC-004 | 90% of urgent goals visually distinct | T055 (urgency highlighting) |
| SC-005 | Responsive mobile/tablet/desktop | T047, T048, T049 (all viewports) |
| SC-006 | 44px+ touch targets | T047 (mobile usability) |
| SC-007 | <2s load time | T056 (reload persistence) |
| SC-008 | WCAG AA contrast | T057 (accessibility) |
| SC-009 | Duplicate prevention | T052 (form validation) |

---

**Status**: ✅ READY FOR IMPLEMENTATION  
**Created**: 2026-03-01  
**Version**: 1.0.0-Tasks  
**Next Action**: Execute Phase 1 tasks, then Phase 2 in parallel
