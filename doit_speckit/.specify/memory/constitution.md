# DoIt SpecKit Constitution

<!-- 
SYNC IMPACT REPORT - Constitution v1.0.0
- Version: Initial creation (v1.0.0)
- Principles Added: I. Clean Code, II. Simple UX, III. Responsive Design, IV. Minimal Dependencies
- Critical Principle: Zero Testing (NO unit tests, integration tests, or e2e tests)—supersedes all other guidance
- Tech Stack Pinned: Next.js 16.1.6, React 19.2.3, React-DOM 19.2.3, Tailwind CSS 4
- Templates Updated: ✅ All references validated; tasks-template acknowledges testing is optional
- Ratified: 2026-03-01
- Status: Active
-->

## Core Principles

### I. Clean Code

Every line of code must be clear, maintainable, and purposeful. Code is communication.

**Non-negotiable requirements**:
- Descriptive naming (functions, variables, components reflect their intent)
- Small, focused functions and components (single responsibility principle)
- No dead code or placeholder comments
- Self-documenting code preferred over inline comments
- Consistent style and formatting across the project

**Rationale**: Clean code reduces cognitive load, minimizes bugs, and accelerates future development. In a learning/studying context, clean code enforces disciplined thinking.

---

### II. Simple UX

User interfaces must be intuitive, uncluttered, and focused on core tasks. Simplicity serves usability.

**Non-negotiable requirements**:
- Minimal visual hierarchy (clear primary action per screen)
- No redundant controls or options ("when in doubt, leave it out")
- Immediate feedback to user interactions (no mystery states)
- Accessible by default (semantic HTML, color contrast, keyboard navigation)
- Consistent navigation and interaction patterns throughout the app

**Rationale**: Simple UX is easier to build, deploy, and maintain. It also reduces support burden and user cognitive overhead.

---

### III. Responsive Design

All interfaces must work seamlessly across device sizes (mobile, tablet, desktop). No response → no release.

**Non-negotiable requirements**:
- Mobile-first design approach (build for small screens, scale to large)
- Fluid layouts using CSS Grid, Flexbox, and Tailwind utility classes
- Touch-friendly interaction targets (minimum 44px for buttons)
- All pages tested on mobile, tablet, and desktop resolutions before shipping
- Images and media scale appropriately without distortion

**Rationale**: Users access our app on diverse devices. Responsive design ensures equal experience and avoids fragmentation.

---

### IV. Minimal Dependencies

Use only the dependencies explicitly required. Every dependency adds maintenance burden and potential risk.

**Non-negotiable requirements**:
- Pinned versions: Next.js 16.1.6, React 19.2.3, React-DOM 19.2.3, Tailwind CSS 4 (no upgrades without amendment)
- No feature library unless built-in alternatives are genuinely insufficient
- Prefer HTML/CSS/React over JavaScript libraries (build custom before adding package)
- Justify any new dependency in code review with clear rationale
- No peer-dependency surprises: transitive dependencies must be audited

**Rationale**: Fewer dependencies = smaller bundle, faster builds, fewer security issues, clearer reasoning about the codebase.

---

## Technology Stack (Pinned)

This project must use:

- **Framework**: Next.js 16.1.6 (App Router mandatory)
- **UI Library**: React 19.2.3
- **DOM**: React-DOM 19.2.3
- **Styling**: Tailwind CSS 4 (with @tailwindcss/postcss)
- **Language**: TypeScript 5+
- **Linting**: ESLint 9+ (Next.js config)
- **Build**: Next.js native (next build)

Any version changes require a formal constitution amendment.

---

## Zero Testing Policy (NON-NEGOTIABLE)

**This supersedes all other guidance in this constitution and all templates.**

- NO unit tests
- NO integration tests
- NO end-to-end (e2e) tests
- NO test suites, frameworks, or test runners

**Quality Assurance Method**: Manual verification during development and code review. Code reviews focus on logic correctness, edge case handling, and compliance with clean code principles.

**Rationale**: For a focused, studies-oriented project, eliminating test infrastructure reduces complexity and allows rapid iteration. Manual review during development is sufficient for scope and scale.

---

## Development Workflow

### Code Review & Approval

All code changes (via pull request) must be reviewed for:
1. Adherence to all four core principles
2. Technology stack compliance
3. No test files or test dependencies added
4. No new dependencies without amendment

### Commit Discipline

- Commits must be atomic and well-described
- Commit messages reference the principle being upheld (e.g., "refactor: simplify component login per clean code principle")

### Release Criteria

- All four principles satisfied
- No testing framework present
- Technology stack exact as pinned
- Manual testing passed by team agreement

---

## Governance

### Amendment Process

Constitution amendments require:
1. Clear justification (which principle is insufficient? why is change needed?)
2. Documented impact on existing code
3. Team consensus before ratification

### Version Bumping

- **MAJOR**: Principle removal, tech stack major upgrade, or fundamental re-scoping
- **MINOR**: New principle added, stack minor upgrade, or new guidance section
- **PATCH**: Clarifications, wording refinements, typo fixes

### Compliance Checks

- Code reviews must explicitly verify principle adherence
- No PR merged if any principle violated
- Constitution is the source of truth; project guidance documents (templates, README) must align

### Templates & Guidance

All Spec Kit templates (`.specify/templates/*.md`) acknowledge that testing is optional and deferrable. Per this constitution: tests are NEVER included. This is binding.

---

**Version**: 1.0.0 | **Ratified**: 2026-03-01 | **Last Amended**: 2026-03-01

