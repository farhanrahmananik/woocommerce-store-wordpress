# Theme & Design System

## Scope Status

- Scope 1: Environment Setup — completed
- Scope 2: Project Initialization — completed
- Scope 3: Store Requirements & Architecture — completed
- Scope 4: Theme & Design System — in progress

## Current Theme Audit Summary

The current local environment provides a clean baseline for a purpose-built DeskNest theme:

- The active theme is Twenty Twenty-Five 1.5.
- Twenty Twenty-Five 1.5, Twenty Twenty-Four 1.5, and Twenty Twenty-Three 1.6 are installed as bundled default block themes.
- No custom theme exists.
- No child theme exists.
- No page-builder plugin is installed.
- WooCommerce is not installed.
- The repository currently ignores all folders under `app/public/wp-content/themes/`.
- Before theme implementation begins, the future DeskNest folder must be explicitly allowlisted in `.gitignore` so only that custom theme can be tracked.

These findings describe the current environment only. No theme has been installed, created, modified, or activated as part of this document.

## Theme Architecture Decision

DeskNest will use a **custom block theme** as its planned theme architecture.

The decision supports:

- **No builder lock-in:** Page composition will not depend on a proprietary visual-builder plugin.
- **No parent-theme dependency:** DeskNest will own its templates, parts, patterns, styles, and release decisions.
- **Central design tokens:** `theme.json` will later provide native settings and shared visual foundations.
- **Native templates and template parts:** Block templates can define page structure, while reusable parts can define elements such as the header and footer.
- **Reusable patterns:** Approved content compositions can be reused without duplicating layout markup.
- **Version-controlled ownership:** The complete custom theme can be reviewed and maintained in Git once explicitly allowlisted.
- **Minimal JavaScript:** Native WordPress behavior and progressive enhancement should be preferred over unnecessary client-side code.
- **Portfolio value:** A focused custom theme demonstrates WordPress architecture, design-system thinking, accessibility, and maintainable frontend implementation more clearly than a prebuilt theme configuration.

The architecture decision does not create or activate the theme. Implementation requires a separately approved step.

## Rejected or Deferred Options

### Elementor or Another Page Builder

Deferred because it would add a plugin dependency, builder-specific markup, potential lock-in, and additional performance/maintenance overhead. A builder should not be introduced without a requirement that native blocks cannot reasonably meet.

### Lightweight Parent Theme and Child Theme

Not preferred because DeskNest does not currently need a parent theme's design system or update path. A child theme would introduce inherited behavior and override complexity while weakening full ownership of the portfolio implementation.

### Custom Classic Theme

Not selected because a classic PHP-template architecture would require more custom template and editor integration work for the planned block-based authoring experience. It remains a valid option for requirements demanding extensive PHP template control, but no such requirement has been identified.

### Direct Modification of a Default Theme

Rejected because bundled themes are external baselines, are ignored by the repository, and may be replaced or updated. Direct edits would be difficult to own, review, and maintain and could be lost during updates.

## Theme Ownership Strategy

- Future theme name: **DeskNest**
- Future theme folder: `desknest`
- Future theme path: `app/public/wp-content/themes/desknest`
- Default themes will remain ignored and unchanged.
- Only the DeskNest custom theme will be explicitly allowlisted when implementation is approved.
- No default-theme file should be copied or modified without a documented reason and appropriate license review.
- Theme activation will be a separate controlled action with before/after validation.

The planned `.gitignore` relationship is:

```gitignore
/app/public/wp-content/themes/*
!/app/public/wp-content/themes/desknest/
!/app/public/wp-content/themes/desknest/**
```

This is a future requirement only; `.gitignore` is not changed in this scope step.

## Planned Block-Theme Structure

The future custom theme should begin with a minimal, purpose-led structure:

```text
desknest/
├── style.css
├── theme.json
├── functions.php
├── templates/
├── parts/
├── patterns/
└── assets/
    ├── css/
    ├── js/
    └── img/
```

- `style.css` will provide valid theme metadata and only the global CSS responsibilities that cannot be handled more appropriately elsewhere.
- `theme.json` will define supported editor settings, presets, and shared design tokens.
- `functions.php` will remain small and load only justified theme setup or assets.
- `templates/` will contain approved block templates.
- `parts/` will contain reusable structural parts such as the header and footer.
- `patterns/` will contain controlled reusable content compositions.
- `assets/` will separate custom styles, scripts, and owned visual assets by responsibility.

Only required files and folders should be created. This map is planning documentation; none of these theme files or directories will exist until an approved implementation step begins.

## Design Direction

DeskNest should feel modern, clean, ergonomic, productivity-focused, calm, trustworthy, and slightly premium. The visual experience should suit a Germany-first commercial brand while remaining adaptable to future EU use.

The direction should favor:

- Functional clarity over decoration.
- Warm neutral surfaces rather than a sterile technology aesthetic.
- Restrained use of a confident accent color.
- Clear hierarchy, generous space, and concise content.
- Consistent product imagery and accurate specification presentation.
- Trustworthy commercial patterns without artificial urgency or exaggerated claims.
- A polished experience that remains approachable to students and home-office customers.

## Product Imagery & Iconography Direction

- Product photography should use consistent lighting, color treatment, scale, and framing across the catalog.
- Primary product images should generally use neutral or light backgrounds so shape, finish, material, and included parts remain clear.
- Context images should show realistic home-office or desk environments without implying unavailable products, unsafe setups, or unsupported ergonomic benefits.
- Primary catalog/product images should provisionally favor a consistent `1:1` aspect ratio.
- Supporting lifestyle imagery may use `4:3` or `3:2` where the composition requires environmental context.
- Category-card images should follow one approved aspect ratio and focal-point rule so cards remain visually stable across breakpoints.
- Icons should be restrained, stylistically consistent, understandable without decoration, and paired with visible text when meaning is not universally clear.
- Decorative icons must not replace semantic labels, validation messages, or accessible control names.
- Every photograph, illustration, icon, and font asset must have verified ownership or licensing and a documented source before repository inclusion or commercial use.

These rules define future asset direction only; no image or icon assets are selected or added in this step.

## Design Tokens

Tokens will later be implemented through `theme.json` and, where appropriate, CSS custom properties. Names and final values must remain consistent across editor and frontend contexts.

| Token category | Planning direction |
| --- | --- |
| Color | Small semantic palette for backgrounds, surfaces, text, borders, accent, and feedback states |
| Typography | Readable sans-serif families with controlled size, weight, and line-height scales |
| Spacing | Predictable scale based on a small base unit rather than one-off values |
| Border radius | Limited levels for controls, cards, larger surfaces, and pill-shaped labels |
| Shadows | Subtle elevation levels used only when hierarchy cannot be communicated by spacing or borders |
| Container widths | Narrow reading, standard content, and wide commerce-layout constraints |
| Breakpoints | Mobile-first behavior validated near 320, 768, 1024, and 1440 CSS pixels |
| Z-index | Named layers for base content, sticky navigation, dropdowns, overlays, modals, and notices if needed |

### Planned Scale Direction

- Spacing candidates: 4, 8, 12, 16, 24, 32, 48, 64, and 96 pixels.
- Radius candidates: 4 pixels for small controls, 8 pixels for standard controls/cards, 12 pixels for larger surfaces, and a full radius for pills.
- Container candidates: approximately 720 pixels for reading content, 1120 pixels for standard layouts, and 1280 pixels for wider catalog layouts.
- Z-index layers should be semantic and sparse; arbitrary large values should be avoided.

Exact implementation values may be refined after real content and future WooCommerce layouts can be tested.

## Suggested Color System

The following restrained palette is a planning proposal. Final combinations must be contrast-tested in their actual text, control, and state contexts before implementation approval.

| Role | Suggested value | Intended use |
| --- | --- | --- |
| Page background | `#F6F7F4` | Warm neutral application background |
| Surface | `#FFFFFF` | Cards, navigation, forms, and raised content |
| Subtle surface | `#ECEFEB` | Secondary panels and grouped information |
| Primary text | `#18211D` | Main headings and body text |
| Secondary text | `#59645E` | Supporting copy and metadata |
| Border | `#D7DDD9` | Dividers and control boundaries |
| Accent | `#2F6F5E` | Primary actions, selected states, and brand emphasis |
| Accent dark | `#245548` | Hover/active direction where contrast testing permits |
| Success | `#2F7A49` | Confirmed success states |
| Warning | `#9A6108` | Cautionary states requiring attention |
| Error | `#B13B3B` | Errors and destructive-state communication |
| Information | `#326B8A` | Neutral informational notices |

State colors must always include text, icons, or labels where meaning would otherwise depend on color alone. Decorative colors should not expand the palette without a defined purpose.

## Typography Strategy

- Prefer a readable modern sans-serif system stack initially, avoiding a font download and its privacy/performance cost.
- A web font may be evaluated later only when it offers clear brand value, suitable licensing, required language coverage, and an acceptable performance strategy.
- Use one primary family unless a second family has a specific, documented role.
- Limit common weights to regular, medium, and bold or an equivalently small set.
- Establish a fluid or responsive heading scale with clear distinction between page title, section heading, subsection, and supporting label.
- Keep body and small-text scales readable; small text must not become the default solution for fitting dense commerce information.
- Body line height should generally support comfortable reading, while headings may use tighter but non-colliding line heights.
- Paragraph width should be constrained for readability even inside wider store layouts.
- Price, quantity, specifications, and form labels should use consistent numeric and emphasis treatment.

### Typography Scale Candidates

The following values are planning candidates, not implemented CSS. Final sizes must be tested with realistic German content, responsive layouts, zoom, and user-configured text scaling.

| Role | Candidate size | Weight direction | Line-height guidance |
| --- | --- | --- | --- |
| Small text | `0.875rem` | Regular or medium | Approximately `1.45–1.55` |
| Body text | `1rem` | Regular | Approximately `1.55–1.65` |
| Lead text | `1.125–1.25rem` | Regular | Approximately `1.5–1.6` |
| H1 | `2.25–3.5rem` responsive range | Bold | Approximately `1.05–1.15` |
| H2 | `1.75–2.5rem` responsive range | Bold | Approximately `1.1–1.2` |
| H3 | `1.375–1.75rem` responsive range | Medium or bold | Approximately `1.2–1.3` |
| H4 | `1.125–1.375rem` responsive range | Medium or bold | Approximately `1.25–1.4` |

Heading margins should use shared spacing tokens, and responsive scaling should preserve hierarchy without forcing German headings into awkward wrapping.

Typography choices remain planning decisions until tested with realistic German product names, compound words, prices, and policy content.

## Layout & Responsive Rules

- Use a mobile-first layout model.
- Support content at approximately 320 CSS pixels without horizontal page scrolling.
- Use responsive side gutters, provisionally 16 pixels on compact screens, 24 pixels on tablet-sized layouts, and 32 pixels on wider screens.
- Keep reading content narrower than product grids or wide commerce sections.
- Use consistent section spacing from the shared spacing scale.
- Product and category grids should respond to available width rather than rely on a fixed desktop column count.
- Cards should preserve readable content order when grids collapse to one column.
- At approximately 768 CSS pixels, evaluate navigation, two-column content, and wider card grids.
- At approximately 1024 CSS pixels, evaluate desktop navigation and multi-column commerce layouts.
- At approximately 1440 CSS pixels, cap content width rather than stretching text and cards indefinitely.
- Images should reserve appropriate space to reduce layout shifts and use responsive sizes when implemented.
- Sticky or fixed interface elements must not hide content, focus indicators, or validation messages.

These values are validation targets, not generated CSS or guaranteed device boundaries.

## Component Planning

The future theme should treat the following as reusable systems rather than one-off page sections:

| Component | Planning responsibility |
| --- | --- |
| Header | Brand identity, primary navigation, utility actions, responsive behavior, and visible focus order |
| Mobile navigation | Accessible open/close behavior, focus management, clear hierarchy, and no-JavaScript fallback consideration |
| Footer | Support, legal, policy, category, and contact navigation without excessive link density |
| Hero section | Concise proposition, meaningful action, restrained media, and responsive content order |
| Category card | Category identity, image, label, optional context, and consistent destination behavior |
| Product card | Future image, title, price, status, action, and variation/availability context governed by WooCommerce requirements |
| Trust badges | Verifiable delivery, returns, warranty, support, or payment messages without unsupported claims |
| Call-to-action block | Clear purpose, one primary action, optional secondary action, and reusable spacing rules |
| Empty state | Explanation, recovery action, and context for empty searches, carts, or account data |
| Form state | Default, hover, focus, filled, disabled, valid, and invalid behavior with persistent labels |
| Alert or notice | Semantic success, warning, error, and information presentation with accessible messaging |

Product and transactional components are interface plans only. They will not be implemented until their relevant WooCommerce scopes begin.

## Shared Interaction-State Rules

| State | Planning rule |
| --- | --- |
| Hover | Provide a restrained visual change for pointer users without making hover the only indication of interactivity. |
| Active/pressed | Clearly acknowledge the current press or selected state without shifting surrounding layout. |
| Focus | Use a persistent, high-visibility focus indicator that is not obscured by shadows, sticky elements, or overflow. |
| Disabled | Reduce emphasis while keeping content legible; disabled controls must not appear actionable and should preserve correct semantics. |
| Loading | Communicate ongoing work, retain context, prevent accidental duplicate actions where needed, and avoid indefinite unexplained states. |
| Invalid/error | Identify the affected control, explain the problem in text, and provide a clear recovery action without relying on color alone. |
| Success | Confirm the completed outcome with concise text and preserve the customer's next logical action. |
| Reduced motion | Remove or simplify non-essential movement when reduced motion is requested; essential state changes must remain understandable. |

Where motion is useful, a restrained transition range of approximately `120–220ms` is a planning candidate for common interface feedback. Duration and easing must match the interaction, avoid delaying tasks, and be validated during implementation.

## Accessibility Requirements

- All interactive controls must be reachable and operable by keyboard.
- Focus indicators must be clearly visible and must not be removed without an accessible replacement.
- Text, controls, borders carrying meaning, and state combinations must be contrast-tested in context.
- Heading levels should communicate document structure rather than visual size alone.
- Links and buttons should remain distinguishable by purpose, semantics, copy, and interaction treatment.
- Navigation and dialogs should use correct semantic elements, labels, states, and focus behavior.
- Motion should respect reduced-motion preferences when animation is introduced.
- Form labels and instructions should remain associated with their controls.
- Validation should identify the field, explain the problem, and provide a recovery path without relying only on color.
- Images should receive meaningful alternative text when informative and empty alternatives when decorative.
- Touch targets, zoom, reflow, and text resizing should be checked before completion claims.

Accessibility must be validated during implementation; this plan does not claim conformance.

## Browser & Device Validation Requirements

- Validate key future journeys in current Chrome, Edge, Firefox, and Safari releases where those browsers are available to the test environment.
- Check representative mobile, tablet, laptop, and desktop widths, including the planned 320, 768, 1024, and 1440 CSS-pixel reference points.
- Complete keyboard-only checks for navigation, menus, dialogs, forms, notices, and future commerce actions.
- Verify touch and pointer behavior where relevant, including target size, hover-independent access, and prevention of accidental actions.
- Test text resizing, zoom, content reflow, long German labels, and error messages without hiding information or introducing horizontal page scrolling.
- Record the tested browser/device matrix and any known limitations instead of making universal compatibility claims.

These are future validation requirements; no browser or device test result is claimed by this planning document.

## WooCommerce Integration Boundaries

- WooCommerce is not installed in this scope.
- No WooCommerce settings, templates, blocks, pages, endpoints, or styles are implemented now.
- The future Shop, category, product detail, cart, checkout, My Account, order, notice, and form experiences must visually align with this design system.
- Product cards and product-detail structures require real WooCommerce output before their final markup and styling decisions can be validated.
- Cart, checkout, account, payment, shipping, tax, and order behavior belong to later approved scopes.
- Theme work must not replace or conceal essential WooCommerce validation, notices, pricing, availability, legal, or accessibility information.
- WooCommerce template overrides should be minimized and justified; native blocks, hooks, and supported styling surfaces should be evaluated first.

## Asset, CSS, and JavaScript Strategy

- Prefer WordPress theme settings and `theme.json` for supported global design controls.
- Use CSS custom properties where a shared semantic token is not adequately represented by native presets or must be consumed by custom CSS.
- Organize CSS by responsibility and avoid broad selectors that unintentionally alter editor or plugin output.
- Keep custom JavaScript minimal, modular, progressively enhanced, and limited to interactions that cannot be handled accessibly with native HTML/CSS or WordPress behavior.
- Avoid unnecessary runtime libraries and duplicate utilities.
- Bootstrap 5 should be introduced only if a later technical review proves that its complete framework value outweighs payload, markup, and design-system conflicts. It is not part of the current plan.
- Do not add a page-builder dependency.
- Prefer optimized local assets with clear ownership and licensing.
- Images should use appropriate formats, dimensions, responsive variants, and lazy loading where suitable when implementation begins.
- Performance must be measured on representative pages and conditions before any improvement or production-readiness claim is made.

## Editor & Frontend Parity Requirements

- `theme.json` tokens and presets must resolve consistently in the block editor and frontend.
- Block gaps, margins, padding, and section spacing should remain predictable between editing and published views.
- Reading, standard, and wide content widths must align across editor previews, templates, and the frontend.
- Typography previews should reliably represent the intended family, scale, weight, line height, and text width.
- Patterns must remain editable and reusable without breaking layout when legitimate content length, media, or ordering changes.
- Editor-only styles should be limited to genuine authoring needs and must not conceal meaningful frontend differences.
- Parity should be tested with representative content before patterns or templates are considered complete.

This is a future quality requirement, not a claim that editor or frontend styles have been implemented.

## Risks & Constraints

| Risk or constraint | Planning response |
| --- | --- |
| Missing `.gitignore` allowlist | Update and validate the explicit `desknest` exception before creating tracked theme files. |
| Default-theme modification | Treat bundled themes as read-only references; never build DeskNest by editing them directly. |
| Overdesign before WooCommerce requirements | Keep transactional components provisional until real WooCommerce structures can be inspected. |
| Accessibility regressions | Define accessible primitives, test key journeys, and review keyboard/focus behavior with every component. |
| CSS bloat | Use shared tokens, restrained utilities, scoped components, and measured additions instead of repeated overrides. |
| Unnecessary JavaScript | Prefer native behavior and require a documented interaction need before adding scripts or libraries. |
| Plugin dependency creep | Use native WordPress capabilities first and review every proposed dependency for ownership, maintenance, security, and performance cost. |
| Editor/frontend drift | Validate that tokens, patterns, content widths, and typography remain coherent in both editing and viewing contexts. |
| Premature template overrides | Prefer supported WordPress/WooCommerce extension surfaces and justify every future override. |
| Unverified commercial styling | Test realistic German content, prices, states, and legal information before describing the storefront as polished or complete. |

## Acceptance Criteria

Scope 4 can be considered complete only when:

- The custom DeskNest block-theme architecture decision and rejected/deferred alternatives are documented.
- Theme ownership, folder path, repository allowlist requirement, and default-theme boundaries are clear.
- Brand direction and the color, typography, spacing, radius, shadow, container, breakpoint, and layering tokens are defined at planning level.
- The typography scale and line-height candidates are documented for small, body, lead, and H1–H4 text roles.
- The minimal planned block-theme file and folder structure is documented without creating it.
- Product imagery, category imagery, iconography, aspect-ratio, ownership, and licensing direction are documented.
- Shared hover, active, focus, disabled, loading, invalid, success, reduced-motion, and transition rules are documented.
- Responsive layout rules and accessibility requirements are documented in verifiable terms.
- Editor/frontend token, spacing, width, typography, and pattern parity requirements are documented.
- Browser/device validation covers current major browsers where available, responsive viewports, keyboard checks, and relevant touch/pointer behavior.
- The planned reusable component inventory covers navigation, content, commerce-facing cards, calls to action, empty states, forms, and notices.
- Asset, CSS, JavaScript, and dependency principles are documented.
- WooCommerce integration boundaries clearly state that no WooCommerce setup or transactional implementation has started.
- Risks and constraints have practical planning responses.
- No custom theme folder, theme activation, plugin installation, WooCommerce setup, product, page, cart, checkout, payment, shipping, or account implementation is included in this planning step.
- Git validation confirms that only the approved Theme & Design System documentation change belongs to this step.

Meeting these criteria approves a design and architecture blueprint for controlled implementation later; it does not mean that the DeskNest theme or storefront has been implemented.
