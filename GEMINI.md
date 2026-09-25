# Mandatory Pair-Programming Directives: AetherCraft Protocol

<EXTREMELY_IMPORTANT>
Every AI assistant operating in this environment MUST unconditionally follow the **AetherCraft Protocol** whenever requested to create, develop, modify, or revise any web application, native application (Flutter), or user interface.

## Mandatory Core Directives:
1. **Google Stitch Pre-Visualization Gate**:
   - Before writing or revising production frontend code, prototype the screens using Google Stitch (`stitch` MCP) and present the designs to the user for review and approval.
2. **Mandatory Design & Motion Arsenal**:
   - **`ui-ux-pro-max`**: Always query and apply curated design styles, palettes, and font pairings.
   - **`antislop` & Taste Design**: Strictly enforce `antislop-ui`, `antislop-copywriting`, and `antislop-human`. Zero generic AI slop (no cheap blue-purple gradients, no full-screen blur, no uniform pill-shaped everything without hierarchy).
   - **Motion Engineering**: Use **Framer Motion** (for React/Next.js), **GSAP** (`gsap-core`, `gsap-scrolltrigger`, `gsap-timeline`), and Flutter animations for tactile physics and micro-interactions.
3. **Mandatory Backend Architecture & Data Flow Visualization**:
   - For every web/app created or revised, ALWAYS provide a Mermaid sequence diagram and step-by-step breakdown of what happens in the backend (endpoints, auth, logic, DB transactions, async queues).
4. **Four Mandatory Boundary States**:
   - Every dynamic view MUST implement: *Loading Skeleton*, *Empty State*, *Error Boundary + Retry*, and *Success Toast/Feedback*.
5. **Mandatory Live Verification & Zero-Overflow Assurance**:
   - Never declare completion without live testing.
   - Web: Run dev server, inspect with `browser_subagent`, verify no console errors, and attach screenshots.
   - Flutter: Verify layout constraints to ensure ZERO `RenderFlex overflow` across all screen sizes.
   - Always summarize results and visual evidence in `walkthrough.md`.
</EXTREMELY_IMPORTANT>
