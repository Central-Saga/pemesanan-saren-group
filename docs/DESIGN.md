---
version: alpha
colors:
  primary: '#1A1B1E'
  accent: '#FF6B00'
  accent-dark: '#E65100'
  accent-light: '#FFA347'
  accent-tint: '#FFF7ED'
  whatsapp: '#16A34A'
  whatsapp-hover: '#15803D'
  surface: '#FFFFFF'
  surface-alt: '#F8FAFC'
  text-primary: '#1A1B1E'
  text-secondary: '#3D4146'
  border: '#E2E8F0'
  success: '#22C55E'
  warning: '#F59E0B'
  surface-dim: '#ddd9d9'
  surface-bright: '#fcf8f8'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f7f3f2'
  surface-container: '#f1eded'
  surface-container-high: '#ebe7e7'
  surface-container-highest: '#e5e2e1'
  on-surface: '#1c1b1c'
  on-surface-variant: '#46474a'
  inverse-surface: '#313030'
  inverse-on-surface: '#f4f0ef'
  outline: '#76777b'
  outline-variant: '#c7c6cb'
  surface-tint: '#a04100'
  on-primary: '#ffffff'
  primary-container: '#351000'
  on-primary-container: '#dd5c00'
  inverse-primary: '#ffb693'
  secondary: '#5e5e62'
  on-secondary: '#ffffff'
  secondary-container: '#e3e2e6'
  on-secondary-container: '#646468'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#1f1b17'
  on-tertiary-container: '#8a837d'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbcc'
  primary-fixed-dim: '#ffb693'
  on-primary-fixed: '#351000'
  on-primary-fixed-variant: '#7a3000'
  secondary-fixed: '#e3e2e6'
  secondary-fixed-dim: '#c7c6ca'
  on-secondary-fixed: '#1a1b1e'
  on-secondary-fixed-variant: '#46474a'
  tertiary-fixed: '#eae1da'
  tertiary-fixed-dim: '#cec5be'
  on-tertiary-fixed: '#1f1b17'
  on-tertiary-fixed-variant: '#4b4641'
  background: '#fcf8f8'
  on-background: '#1c1b1c'
  surface-variant: '#e5e2e1'
typography:
  font-primary: Plus Jakarta Sans, sans-serif
  font-mono: JetBrains Mono, monospace
  h1: 700 2.5rem/1.2 {typography.font-primary}
  h2: 700 2rem/1.3 {typography.font-primary}
  body-lg: 400 1.125rem/1.6 {typography.font-primary}
  body-md: 400 1rem/1.6 {typography.font-primary}
  body-sm: 400 0.875rem/1.5 {typography.font-primary}
  mono-code: 500 0.875rem/1.5 {typography.font-mono}
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 42px
  technical-md:
    fontFamily: JetBrains Mono
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 21px
rounded:
  sm: 4px
  md: 8px
  lg: 12px
  full: 9999px
  DEFAULT: 0.5rem
  xl: 1.5rem
spacing:
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  xxl: 48px
  base: 8px
  container-max: 1280px
  gutter: 24px
components:
  button-primary:
    background: '{colors.accent}'
    text: '{colors.surface}'
    radius: '{rounded.md}'
    padding: '{spacing.sm} {spacing.lg}'
  button-primary-hover:
    background: '{colors.accent-dark}'
  button-whatsapp:
    background: '{colors.whatsapp}'
    text: '{colors.surface}'
    radius: '{rounded.md}'
    padding: '{spacing.sm} {spacing.lg}'
  button-whatsapp-hover:
    background: '{colors.whatsapp-hover}'
  calculator-card:
    background: '{colors.surface}'
    border: 1px solid {colors.border}
    shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1)
    focus-ring: 2px solid {colors.accent}
  dropzone-artwork:
    background: '{colors.surface-alt}'
    border: 2px dashed {colors.border}
    border-active: 2px dashed {colors.accent}
    radius: '{rounded.lg}'
  badge:
    radius: '{rounded.full}'
    padding: 2px 12px
    font: '{typography.body-sm}'
name: Saren Precision
---

# CV. Saren Grup Design System

## 1. Overview
Founded in 2009 as **Saren Komputer** and evolving into **CV. Saren Grup** in 2015, we are a modern digital printing and e-commerce leader based in Sibang Kaja, Badung, Bali. This design system bridges our architectural heritage with digital-first efficiency, catering to precision printing, custom dimensions, and seamless WhatsApp-integrated commerce.

## 2. Colors
Our palette is derived directly from the "S" monogram and architectural roofline logo.
- **Saren Vibrant Orange (`#FF6B00`)**: Core energetic accent representing growth and dynamic service.
- **Charcoal Ink (`#1A1B1E`)**: Structural neutral for headlines and core brand elements.
- **Pure White (`#FFFFFF`)**: Clean negative space for high-legibility layouts.
- **WhatsApp Green (`#16A34A`)**: Dedicated action color for checkout and customer support.

## 3. Typography
We use **Plus Jakarta Sans** for its geometric clarity and modern UI feel. For technical data—such as invoice codes (`SRN-20231027-0001`), dimension math (m²), and Rupiah pricing—**JetBrains Mono** provides the necessary tabular precision.

## 4. Layout & Spacing
A rigorous 8px grid system ensures alignment across complex printing calculators and product grids.
- **Gutter**: 24px (Desktop)
- **Container Max-Width**: 1280px

## 5. Elevation & Depth
Subtle bevels and soft shadows mirror the structured block aesthetic of the brand logo. 
- **Surface**: Flat white.
- **Elevated**: 4px blur, 10% opacity charcoal shadow for interactive cards.

## 6. Shapes
We utilize a "Crisp Geometric" approach. 
- Standard UI components use **8px (Medium)** rounding.
- Technical cards and large containers use **12px (Large)**.
- Precision inputs maintain sharper **4px (Small)** corners to reflect technical accuracy.

## 7. Components
- **Primary Action**: High-contrast Orange buttons for "Add to Cart" or "Calculate".
- **WhatsApp Checkout**: Distinct Emerald Green buttons for direct peer-to-peer commerce.
- **Calculator Inputs**: Focused dimension fields (Width/Height) utilize Orange rings to highlight active user attention.
- **Status Badges**:
  - `Pending`: Amber
  - `In Production`: Saren Orange
  - `Ready for Pickup`: Emerald Green

## 8. Do's and Don'ts
- **Do**: Use JetBrains Mono for all mathematical results and invoice IDs.
- **Do**: Ensure text on Orange backgrounds uses Pure White for WCAG AA compliance.
- **Don't**: Use secondary neutrals for primary call-to-actions.
- **Don't**: Apply rounded corners greater than 12px to structural cards; keep the geometric integrity.