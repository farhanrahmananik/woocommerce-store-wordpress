# Product Catalog

## Scope Status

- Scope 1: Environment Setup - completed
- Scope 2: Project Initialization - completed
- Scope 3: Store Requirements & Architecture - completed
- Scope 4: Theme & Design System - completed
- Scope 5: WooCommerce Foundation - completed
- Scope 6: Product Catalog - completed

## Scope 6 Purpose and Boundaries

This document is the catalog planning and implementation record for the DeskNest product catalog. It defines the approved category structure and records the implemented simple products with their names, SKUs, categories, prices, and content/image direction, while preserving an explicit note on which products are later variable-product candidates.

The catalog follows directly from the strategy, category set, price range, and attribute/taxonomy planning recorded in [Store Requirements & Architecture](store-requirements-architecture.md), and uses the Germany/EUR foundation recorded in [WooCommerce Foundation](woocommerce-foundation.md).

The approved catalog was implemented in WooCommerce at a deliberately limited foundation level: six DeskNest product categories and 24 published products exist. At the end of Scope 6, the implementation had not created product attributes, variations, tags, featured images, or inventory workflows, and it did not change taxes, payments, shipping, cart, checkout, accounts, plugins, themes, or storefront UI.

Scope 6 remained limited to the approved category and simple-product catalog. Product attributes, product variations, advanced inventory workflows, taxes, shipping, payments, cart, checkout, customer accounts, storefront UI, plugins, and theme changes remained excluded from Scope 6 itself.

**Update following Scope 7**: global product attributes and variations have since been implemented for 5 of the 24 products (`DN-ERG-001`, `DN-ERG-002`, `DN-ORG-001`, `DN-LIT-001`, `DN-PRD-001`), which are now variable products with 11 total variations. The other 19 products remain simple products, unchanged. Full details are documented in [Product Attributes & Variations](product-attributes-variations.md). Product tags, featured images, taxes, shipping, payments, cart, checkout, accounts, plugins, themes, and storefront UI remain unimplemented.

**Update following Scope 8**: an inventory and stock-management policy has since been applied. All 19 simple products and all 11 variations now have quantity tracking enabled with realistic stock levels; the 5 variable parent products remain parent-level untracked, consistent with WooCommerce's own design (availability is derived from their variations). Full details, including two intentional out-of-stock test items, are documented in [Inventory & Stock Management](inventory-stock-management.md). Storefront/cart/checkout behavior with this inventory has not been tested yet.

## Implementation Summary

- Six DeskNest product categories were created with the approved names, slugs, and descriptions.
- Twenty-four simple products were created and published with the approved names, SKUs, EUR prices, descriptions, and single primary-category assignments.
- WooCommerce's default `Uncategorized` category remains unchanged and contains 0 products.
- Every DeskNest product has `publish` status and visible catalog visibility.
- Every DeskNest product is assigned to exactly one product category.
- No product image or featured image is assigned in this scope.
- Stock management was intentionally disabled for every product at the end of Scope 6; no stock quantities, thresholds, or backorder rules existed yet. (Update: Scope 8 later enabled quantity tracking for all 19 simple products - see [Inventory & Stock Management](inventory-stock-management.md).)
- Future variable-product candidates remained simple products at the end of Scope 6; no product attributes or variations existed yet. (Update: 5 of these candidates became variable products in Scope 7 - see [Product Attributes & Variations](product-attributes-variations.md).)

## Product Catalog Strategy for DeskNest

The catalog stays within the curated, Germany-first desk-setup and workspace-accessories niche already defined for DeskNest: practical, well-designed physical accessories for home-office and hybrid workspaces, priced in the accessible mid-range with a few higher-value ergonomic items, and organized so category browsing feels focused rather than like an unrestricted general marketplace.

The implemented catalog contains **24 products** in total, within the 20-28 range required for this scope and consistent with Scope 3's overall 24-32-product sizing guidance. At the end of Scope 6, all 24 were WooCommerce **simple products**. As of Scope 7, 5 of those (the products flagged below as variable-product candidates) are now WooCommerce **variable products** with global attributes and variations; the other 19 remain simple products. See [Product Attributes & Variations](product-attributes-variations.md) for full detail.

## Category Structure

The implemented category structure reuses the six merchandising categories already defined in Scope 3:

| Category | Purpose | Planned product count |
| --- | --- | ---: |
| Ergonomic Essentials | Positioning and comfort - stands, risers, footrests, wrist support | 5 |
| Desk Organization | Trays, organizers, storage, pen/document holders | 4 |
| Lighting & Ambience | Task lamps, monitor light bars, ambient desk lighting | 4 |
| Cable Management | Trays, clips, sleeves, routing accessories | 4 |
| Productivity Accessories | Desk mats, device stands, focus and workspace aids | 5 |
| Bundles | Purpose-led product combinations sold as a single simple product | 2 |
| **Total** | | **24** |

All six DeskNest categories now exist in WooCommerce. WooCommerce's default `Uncategorized` category also remains present, giving 7 product categories in total.

## Suggested Product Data Fields

Each implemented product is recorded using the following fields. Core commerce fields are now populated in WooCommerce; the description and image directions remain useful content guidance for later refinement.

| Field | Direction |
| --- | --- |
| Product name | Clear, descriptive, customer-searchable; avoids exaggerated or unverifiable claims |
| Product type | Simple, for all 24 products in this scope |
| Category | One primary category from the structure above (no duplicate primary categories) |
| SKU | Unique, human-readable, follows the convention in [SKU Naming Convention](#sku-naming-convention) |
| Regular price (EUR) | Realistic mid-range German/EU retail price; see pricing notes below |
| Short description direction | One-line framing for the catalog/loop context (what it is, primary benefit) |
| Full description direction | What the eventual long-form copy should cover: material, dimensions/compatibility, adjustability, included components, and honest use-case framing - not the final copy itself |
| Product image placeholder strategy | See [Product Image Placeholder Strategy](#product-image-placeholder-strategy) |

## Product Catalog Plan

Implemented prices follow Scope 3's price-positioning guidance (overall EUR 12-EUR 180, most products in the EUR 25-EUR 90 mid-range). Small individual accessories (clip sets, holders, sleeves) are intentionally priced below EUR 25, which reflects realistic German/EU retail pricing for that product size and type rather than a deviation from the mid-range positioning - larger or more complex items sit within or above the EUR 25-EUR 90 band. No product in this catalog exceeds EUR 90; the architecture document's EUR 180 ceiling is reserved for future premium/ergonomic items not included in this initial 24.

The tables below preserve the approved planning record. The live WooCommerce products use the same names, SKUs, categories, and prices, with published short and full descriptions based on these directions. The content remains portfolio sample copy rather than a claim about verified supplied goods.

### Ergonomic Essentials

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 1 | Adjustable Aluminum Laptop Stand | `DN-ERG-001` | 39.90 | Implemented (Scope 7) - Finish: Black, Silver | Material (aluminum), height/angle adjustability, laptop size compatibility, ventilation benefit |
| 2 | Wooden Monitor Riser | `DN-ERG-002` | 44.90-49.90 | Implemented (Scope 7) - Size: 60 cm, 80 cm | Wood type/finish, load capacity, monitor size fit, under-riser storage space |
| 3 | Ergonomic Footrest, Adjustable Height & Tilt | `DN-ERG-003` | 34.90 | No | Adjustable mechanism, seated posture benefit, non-slip base, floor protection |
| 4 | Memory-Foam Wrist Rest Set (Keyboard + Mouse) | `DN-ERG-004` | 19.90 | No | Foam density/material, set contents, wrist-support use case, care instructions |
| 5 | Under-Desk Footrest Rocker Board | `DN-ERG-005` | 29.90 | No | Rocking range, grip surface, seated-movement benefit, size/weight limits |

### Desk Organization

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 6 | Modular Bamboo Desk Organizer | `DN-ORG-001` | 27.90-32.90 | Implemented (Scope 7) - Size: Compact, Standard | Bamboo material, modular components, configuration options, desk footprint |
| 7 | Stackable Document Tray, 3-Tier | `DN-ORG-002` | 24.90 | No | Tier count, paper size fit, stacking/mounting, material and finish |
| 8 | Felt Desktop Storage Caddy | `DN-ORG-003` | 18.90 | No | Felt material, compartment layout, intended contents, care notes |
| 9 | Wooden Pen and Accessory Holder | `DN-ORG-004` | 14.90 | No | Wood finish, compartment count, footprint, desk-pairing suggestions |

### Lighting & Ambience

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 10 | Dimmable USB-C Monitor Light Bar | `DN-LIT-001` | 49.90 | Implemented (Scope 7) - Finish: Black, Silver | Mounting method, brightness/dimming range, color temperature, monitor compatibility |
| 11 | Compact LED Desk Lamp, Adjustable Color Temperature | `DN-LIT-002` | 36.90 | No | Color-temperature range, arm adjustability, power source, footprint |
| 12 | Clip-On Task Light for Shelves and Monitors | `DN-LIT-003` | 24.90 | No | Clip mechanism/range, brightness levels, cable/power detail, mounting surfaces |
| 13 | Ambient LED Desk Strip with Touch Control | `DN-LIT-004` | 21.90 | No | Strip length, touch-control behavior, mounting method, ambient (non-task) use framing |

### Cable Management

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 14 | Under-Desk Steel Cable Tray | `DN-CAB-001` | 26.90 | No | Load capacity, mounting hardware/method, desk-thickness fit, cable capacity |
| 15 | Reusable Cable Clip Set (12-Piece) | `DN-CAB-002` | 12.90 | No | Piece count, adhesive/mount type, cable diameter range, reusability |
| 16 | Braided Cable Sleeve Kit, 1.5m | `DN-CAB-003` | 16.90 | No | Sleeve material, length, cable-bundle capacity, included fasteners |
| 17 | Adhesive Cable Routing Channel Kit | `DN-CAB-004` | 14.90 | No | Channel length/count, adhesive type, surface suitability, install guidance |

### Productivity Accessories

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 18 | Vegan-Leather Desk Mat, Large | `DN-PRD-001` | 32.90 | Implemented (Scope 7) - Color: Black, Grey, Green | Material, dimensions, water-resistance, surface feel for mouse/typing use |
| 19 | Vertical Laptop and Tablet Stand, Adjustable Width | `DN-PRD-002` | 29.90 | No | Width-adjustment range, device compatibility, base stability, footprint |
| 20 | Wooden Headphone Stand | `DN-PRD-003` | 19.90 | No | Wood finish, headphone-size compatibility, base stability, footprint |
| 21 | Analog Desk Timer for Focused Work Sessions | `DN-PRD-004` | 17.90 | No | Timer mechanism, duration range, intended focus-session use, desk footprint |
| 22 | Magnetic Notepad and Stylus Holder | `DN-PRD-005` | 13.90 | No | Magnetic mount, notepad size fit, stylus/pen holding detail, mounting surfaces |

### Bundles

| # | Product name | SKU | Price (EUR) | Variable candidate? | Description direction |
| ---: | --- | --- | ---: | --- | --- |
| 23 | DeskNest Starter Workspace Bundle (laptop stand, desk mat, cable clip set) | `DN-BND-001` | 79.90 | No | Bundle contents, combined value framing, compatibility across included items |
| 24 | DeskNest Cable-Control Bundle (cable tray, sleeve kit, clip set, routing channel kit) | `DN-BND-002` | 54.90 | No | Bundle contents, combined value framing, realistic under-desk cable scenario |

Each bundle in the implemented catalog is stored as a single simple product with fixed contents; it is not a WooCommerce grouped/composite product and has no variation logic. Whether bundles should later become a different WooCommerce product type requires a separately approved technical decision.

## Products With Implemented Attributes and Variations (Scope 7)

At the end of Scope 6, the following products were flagged only as **future variable-product candidates**, with no attributes or variations created. As of Scope 7, all 5 have been implemented as WooCommerce variable products with global attributes and variations. Full attribute, term, and variation detail is documented in [Product Attributes & Variations](product-attributes-variations.md); this table is kept here for catalog continuity.

| SKU | Product | Implemented attribute | Variation count |
| --- | --- | --- | ---: |
| `DN-ERG-001` | Adjustable Aluminum Laptop Stand | Finish (Black, Silver) | 2 |
| `DN-ERG-002` | Wooden Monitor Riser | Size (60 cm, 80 cm) | 2 |
| `DN-ORG-001` | Modular Bamboo Desk Organizer | Size (Compact, Standard) | 2 |
| `DN-LIT-001` | Dimmable USB-C Monitor Light Bar | Finish (Black, Silver) | 2 |
| `DN-PRD-001` | Vegan-Leather Desk Mat, Large | Color (Black, Grey, Green) | 3 |

This matches the variable-product candidates already anticipated in Scope 3's attribute and taxonomy planning (desk mats, stands, organizers, and lighting).

## Product Image Placeholder Strategy

No featured images are assigned to the implemented products. Future media work should follow this direction:

- Use neutral placeholder imagery only until licensed or original product photography is available; placeholders must be clearly non-final and must not imply a real supplied product.
- Name placeholder files after the product SKU (for example, `dn-erg-001.jpg`) so image ownership stays traceable per product.
- Follow the aspect-ratio direction already set in [Theme & Design System](theme-design-system.md): a consistent `1:1` ratio for primary catalog/product images, with `4:3`/`3:2` reserved for supporting lifestyle imagery only.
- Defer real image sourcing, licensing verification, and asset upload to a separately approved media/content step; this document does not select or commit any image asset.

## SKU Naming Convention

SKUs follow a consistent, human-readable pattern: `DN-<CATEGORY>-<SEQUENCE>`.

- `DN` - fixed DeskNest store prefix.
- `<CATEGORY>` - three-letter category code: `ERG` (Ergonomic Essentials), `ORG` (Desk Organization), `LIT` (Lighting & Ambience), `CAB` (Cable Management), `PRD` (Productivity Accessories), `BND` (Bundles).
- `<SEQUENCE>` - zero-padded three-digit sequence, unique within its category code.

This convention must remain unique across all future simple products, variations, and bundles, consistent with the SKU requirement already recorded in Scope 3's operational assumptions. If a flagged product later becomes variable, its variation SKUs should extend the base SKU (for example, `DN-ERG-001-BLK`) rather than replace it.

## Validation Summary

The implemented WooCommerce catalog was validated with the following final state **at the end of Scope 6**. Product variations, global attributes, product-level attribute assignments, and stock management have since changed - see the Scope 7 and Scope 8 update notes above, [Product Attributes & Variations](product-attributes-variations.md), and [Inventory & Stock Management](inventory-stock-management.md) for the current live state (5 variable products, 11 variations, 3 global attributes, 30 items with stock management enabled).

| Item | Final state |
| --- | ---: |
| Products | 24 |
| Product variations | 0 |
| Product tags | 0 |
| Global product attributes | 0 |
| Product categories | 7 total, including `Uncategorized` |
| Product attributes assigned to products | 0 |
| Featured images assigned | 0 |
| Products with stock management enabled | 0 |

Additional validation confirmed that all 24 products are simple, published, visible in the catalog, and assigned to exactly one category. Category product counts are 5, 4, 4, 4, 5, and 2 across the six DeskNest categories; `Uncategorized` remains at 0.

## Exclusions and Deferred Work

The following remain intentionally excluded from Scope 6:

- Product attributes and product variations.
- Product tags and advanced taxonomy work.
- Product images, media sourcing, and licensing work.
- Stock quantities, low-stock thresholds, backorders, and advanced inventory workflows.
- Taxes, shipping, payments, cart, checkout, and customer-account configuration or customization.
- Storefront UI, plugins, and theme changes.
- Changes to the approved product types, category structure, or future variation model without a separate review.

## Acceptance Criteria

The Scope 6 catalog record can be considered complete only when:

- The category structure, product count, and per-category allocation are defined and consistent with Scope 3's catalog strategy.
- The six approved categories and 24 realistic simple products exist with the documented names, types, category assignments, SKUs, EUR prices, and description/image direction.
- Pricing is realistic for a mid-range German/EU commercial store and consistent with Scope 3's price-positioning guidance.
- SKU naming is consistent, unique, and documented.
- Future variable-product candidates are clearly marked without defining any variation.
- Live validation confirms 24 published, visible simple products; 7 total product categories; and zero variations, tags, global attributes, product attributes, featured images, or stock-managed products.
- Items excluded from Scope 6 are listed without ambiguity.
- Git validation confirms that only `docs/product-catalog.md` is pending as a documentation change, with no plugin, theme, README, or unrelated tracked file changes.

Meeting these criteria records the completed limited catalog implementation accurately. It does not mean that attributes, variations, images, inventory workflows, taxes, shipping, payments, transactional customization, or storefront UI have been implemented.
