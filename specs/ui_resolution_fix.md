# UI Resolution & Overflow Fix Plan - SelectionView

## Problem Description
In `SelectionView.jsx`, the `BrandCard` tiles currently overflow at the bottom of the screen. Because the application uses `overflow-hidden` on the body and main containers (standard for kiosk/totem apps), the user cannot see or interact with all brands. Furthermore, the use of fixed pixel values (`w-96`, `text-7xl`) makes the UI rigid across different Android device resolutions.

## Goals
1.  **Adaptive Scaling:** Transition from fixed pixels to relative units (`vw`, `vh`) for proportional scaling.
2.  **Resolution Independence:** Implement a scaling strategy based on viewport width.
3.  **Containment:** Ensure all 3 brand tiles are visible within the viewport without breaking the layout.
4.  **Grid Optimization:** Use a 3-column grid to utilize horizontal space and prevent vertical overflow.

---

## Proposed Changes

### 1. SelectionView Layout (`resources/js/Pages/Home/Views/SelectionView.jsx`)
- **Header Scaling:** Replace `text-7xl md:text-8xl` with `text-[5vw]`.
- **Flexible Grid:** 
    - Change `grid-cols-1` to `grid-cols-3` to fit all brands horizontally.
    - Replace `gap-12` and `gap-5` with `gap-[2vw]`.
    - Replace `py-12 px-6` with `py-[4vh] px-[4vw]`.
- **Vertical Containment:** Use `flex-1` and `overflow-hidden` on the main container to ensure it stays within the viewport.

### 2. BrandCard Scaling (`resources/js/Pages/Home/Components/BrandCard.jsx`)
- **Relative Dimensions:** Replace `w-96` with `w-[22vw]`.
- **Aspect Ratio:** Use `aspect-[4/5]` instead of `min-h-[380px]`.
- **Internal Scaling:**
    - Replace `p-10` with `p-[2vw]`.
    - Replace `rounded-[3rem]` with `rounded-[3vw]`.
    - Scale text sizes (e.g., `text-5xl` to `text-[2.5vw]`).
    - Scale logo container (`w-44 h-44` to `w-[10vw] h-[10vw]`).

### 3. Global CSS (`resources/css/app.css`)
- Ensure the `nativephp-safe-area` class handles padding correctly on devices with notches or navigation bars using `padding: env(safe-area-inset-...)`.

---

## Implementation Steps

### Step 1: Update SelectionView
Modify the grid structure and spacing to use viewport units. Change the column count to 3 to accommodate all brands on a single row.

### Step 2: Update BrandCard
Refactor the card component to use `vw` for all dimensions, ensuring the card remains proportional regardless of the screen width.

### Step 3: Verification
- Verify that all three brands (Ariston, Chaffoteaux, Wolf) are visible simultaneously on 1080p and 720p resolutions.
- Ensure that the "INIZIA ORA" button is reachable and not clipped at the bottom.
