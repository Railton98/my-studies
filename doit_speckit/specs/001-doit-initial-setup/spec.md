# Feature Specification: DoIt Initial Page Setup

**Feature Branch**: `001-doit-initial-setup`  
**Created**: 2026-03-01  
**Status**: Draft  
**Input**: User description: "initial page setup - this application should be a goal tracking web app called 'doit'. There should be two columns - a left one where current goals are shown, along with how many days left the user has to achieve the goal, and right one where completed goals are. Each goal can be 'checked' using a checkbox, and then either moved to the completed column or permanently deleted. To add new goals, a user can click on a button to open a new goal form in a modal (title and end date fields). Goals reaching their end date (within 3 days) are highlighted. Let's use a modern light theme with fun pastel colours."

## User Scenarios & Manual Verification *(mandatory)*

### User Story 1 - View Dashboard with Goal Columns (Priority: P1)

User lands on the DoIt application and sees a clean two-column dashboard layout showing their current goals and completed goals. This is the core MVP—users immediately understand the app's purpose and status of their goals.

**Why this priority**: This is the foundational UX. Without a clear view of goals, users cannot interact with anything else. Viewing goals is the primary value delivered.

**Manual Verification Method**: Can be verified by loading the application and visually confirming:
- Left column display exists and shows current goals
- Right column display exists and shows completed goals
- Each goal displays its title and days remaining
- Layout adapts responsively across mobile/tablet/desktop

**Acceptance Scenarios**:

1. **Given** user has no goals yet, **When** they first visit the app, **Then** they see both columns are empty with helpful placeholder text
2. **Given** user has 3 current goals and 2 completed goals, **When** they load the app, **Then** left column displays all 3 current goals with deadline info and right column displays 2 completed goals
3. **Given** a goal ends on 2026-03-05 and today is 2026-03-01, **When** viewing the dashboard, **Then** the goal shows "4 days left"
4. **Given** viewing on mobile device, **When** the page renders, **Then** columns stack vertically or adapt layout, all text remains readable

---

### User Story 2 - Add New Goal via Modal (Priority: P2)

User clicks a button to open a form where they can create a new goal by entering a title and end date. The goal is then added to the current goals column. This enables users to build their goal list.

**Why this priority**: P2 because the app is not useful without users being able to create goals. This is the second critical flow after viewing goals.

**Manual Verification Method**: Can be verified by:
- Clicking the "Add Goal" button and confirming modal appears
- Filling the form with title and date, submitting it
- Confirming the new goal appears in the left column with correct deadline
- Verifying empty/invalid form submissions don't create goals

**Acceptance Scenarios**:

1. **Given** user is viewing the dashboard, **When** they click the "Add Goal" button, **Then** a modal form opens with "Title" and "End Date" fields and a "Create" button
2. **Given** modal is open and empty, **When** user enters title "Learn TypeScript" and date "2026-04-01", **Then** they can click "Create" and the goal appears in the current goals column
3. **Given** user enters an end date in the past, **When** they attempt to submit, **Then** the form shows a validation error and does not create the goal
4. **Given** the modal is open, **When** user clicks outside the modal or a close button, **Then** the modal closes without creating a goal

---

### User Story 3 - Complete or Delete a Goal (Priority: P3)

User can check a goal checkbox to mark it as complete (moving it to the completed column) or permanently delete it. This allows users to manage their goal progress.

**Why this priority**: P3 because while important for ongoing use, viewing and creating goals are the core MVPs. Goal management is the next value-add layer.

**Manual Verification Method**: Can be verified by:
- Checking a goal checkbox
- Observing the goal moved to completed column
- Confirming delete action removes the goal entirely
- Confirming undo/permanent deletion behavior is clear to users

**Acceptance Scenarios**:

1. **Given** a goal exists in the current column, **When** user clicks the checkbox, **Then** the goal is moved to the completed goals column
2. **Given** a goal exists in completed column, **When** user clicks a delete button on that goal, **Then** a confirmation prompt appears
3. **Given** confirmation prompt is shown, **When** user confirms deletion, **Then** the goal is permanently removed from the app
4. **Given** a goal is in current column, **When** user clicks the delete button directly, **Then** the goal is removed from the current column

---

### User Story 4 - Visual Urgency Highlighting for Deadlines (Priority: P3)

Goals that have a deadline within 3 days (including today) are visually highlighted with a special style to alert the user. This helps users prioritize urgent tasks.

**Why this priority**: P3 because visual enhancement improves UX but isn't required for core functionality. Users can still see raw deadline numbers without highlighting.

**Manual Verification Method**: Can be verified by:
- Creating goals with various deadline distances
- Checking that goals 0-3 days away have distinct visual styling (e.g., highlighted background, border color)
- Confirming goals 4+ days away do not have this styling
- Verifying the highlighting updates correctly as days pass

**Acceptance Scenarios**:

1. **Given** a goal ends 2 days from today, **When** viewed in the dashboard, **Then** it has a distinct highlighted/urgent styling (e.g., pastel red/pink background)
2. **Given** a goal ends 5 days from today, **When** viewed in the dashboard, **Then** it does not have urgent highlighting
3. **Given** today is 2026-03-01 and a goal ends 2026-03-03, **When** the user views the dashboard, **Then** the goal is highlighted as urgent
4. **Given** today becomes 2026-03-04 (next day in mock), **When** that same goal is viewed now, **Then** the highlighting adjusts accordingly or is removed if deadline has passed

---

### Edge Cases

- What happens when an end date is set to today? → Goal shows "0 days left" and is highlighted as urgent
- How does the system handle goals with end dates in the past? → User should not be able to create them; if they exist, they should show in completed column or be marked as overdue
- What if no title is entered in the modal? → Form validation prevents submission with empty title
- What if user deletes all goals? → Both columns show empty state with helpful messaging
- How does the app behave on extremely narrow mobile screens? → Layout remains usable; columns may stack with clear separation

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST display a two-column layout with "Current Goals" and "Completed Goals" sections
- **FR-002**: System MUST display each current goal with its title and days remaining calculated from today to end date
- **FR-003**: System MUST provide an "Add Goal" button that opens a modal form with "Title" (text input) and "End Date" (date picker) fields
- **FR-004**: System MUST create a new goal when user submits the modal form with valid title and future/today end date
- **FR-005**: System MUST validate that goal title is not empty and end date is not in the past; show error message if invalid
- **FR-006**: System MUST provide a checkbox or button on each current goal to mark it as complete and move it to the completed column
- **FR-007**: System MUST provide a delete button on each goal (current or completed) that removes it permanently (with confirmation for non-completed goals)
- **FR-008**: System MUST apply distinct visual highlighting to goals with end date within 3 days from today (urgency indicator)
- **FR-009**: System MUST persist goals in browser storage or database (user choice—document assumption) so goals survive page reload
- **FR-010**: System MUST display empty state messaging when columns have no goals

### Key Entities

- **Goal**: Represents a user objective with: title (string), end_date (date), created_date (date), status (enum: "current" or "completed"), days_remaining (calculated, not stored)
- **UIState**: Current state of the modal (open/closed), selected goal for deletion confirmation, any error messages from form validation

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: New user can view empty dashboard and understand the app's purpose within 10 seconds of loading
- **SC-002**: User can create a new goal in under 30 seconds (navigate button → fill modal → submit)
- **SC-003**: User can complete a goal with a single click/interaction and see it move to completed column instantly
- **SC-004**: 90% of goals within 3-day deadline are visually distinguishable from other goals on first glance
- **SC-005**: Dashboard remains responsive and usable on mobile (375px width), tablet (768px), and desktop (1920px+) screens
- **SC-006**: All interactive elements (buttons, checkboxes, date picker) are at least 44px in touch-target size on mobile
- **SC-007**: Pages load and display initial state in under 2 seconds on standard connections
- **SC-008**: Users can navigate and use the app in light mode with no contrast issues; WCAG AA level contrast minimum

---

**Version**: 1.0.0-Draft | **Base Date**: 2026-03-01
