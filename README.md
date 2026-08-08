# Ecommet – White-Label Multitenant Ecommerce Website Builder (AI Powered)

> ⚠️ **View-Only Repository** — This code is publicly shared for portfolio and code review purposes only.
> Unauthorized use, copying, or distribution is strictly prohibited. See [LICENSE](./LICENSE) for details.

---

## 📌 About This Project

**Ecommet** is a full-featured E-Commerce web application built with **Laravel** (PHP), developed under **KreativDev**. This repository is publicly shared as a portfolio showcase so that recruiters, technical leads, and hiring managers can review the code structure, architecture, and engineering practices.

---

## 🛠️ Tech Stack

| Layer        | Technology              |
|--------------|-------------------------|
| Backend      | PHP / Laravel 8+        |
| Frontend     | Blade Templates, JS     |
| Database     | MySQL                   |
| Styling      | Bootstrap / CSS         |
| Auth         | Laravel Auth / Guards   |

---

## 🗂️ Project Structure Highlights

```
ecommet/
├── app/
│   ├── Http/Controllers/   # All controllers (Admin, User, API)
│   ├── Models/             # Eloquent models
│   └── ...
├── resources/
│   ├── views/              # Blade templates
│   └── js/ / css/          # Frontend assets
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── database/
│   ├── migrations/         # DB migrations
│   └── seeders/            # DB seeders
└── config/                 # App configurations
```

---

## ✨ Authentic Key Features

### 🏢 Multi-Tenancy & SaaS Architecture
- **Tenant Store Builder:** Enables Super Admin to create subscription plans (Free Trial, Monthly, Yearly, Lifetime) and manage tenant stores.
- **Custom Domains & Subdomains:** Supports tenant custom domain mapping and subdomains for tenant storefronts.
- **Tenant Management:** Complete admin panel for subscription tracking, package limits, and tenant user permissions.

### 🤖 AI Integration (OpenAI & Google Gemini)
- **AI Content Generator:** Integrated with **OpenAI (GPT-4o)** & **Google Gemini (2.0 Flash)** for automated product title, description, and SEO meta generation.
- **AI Image Generator:** Integrated with **DALL-E 3**, **Imagen 4.0**, and **Pollinations AI** for automated product image generation.

### 🎨 Multiple Niche Themes
- **9+ Pre-built Themes:** Includes pre-designed templates tailored for Multipurpose, Grocery, Electronics, Fashion, Kids, and Furniture stores.
- **Dynamic Layout Builder:** Theme color presets, custom header/footer customization, and drag-and-drop section management.

### 💳 Payment Gateways & Financials
- **19+ Automated Payment Gateways:** PayPal, Stripe, Mollie, Razorpay, PayTM, Instamojo, Authorize.Net, Iyzico, MyFatoorah, Midtrans, and more.
- **Offline Payments & Invoicing:** Supports bank transfer / offline payment methods and automated PDF invoice generation.

### 🌐 Global Readiness (Multilingual & RTL)
- **Multi-Language & RTL:** Multi-language support with native Right-to-Left (RTL) layout compatibility.
- **Multi-Currency:** Multi-currency management with real-time rate adjustments.

### 📦 Product & Storefront Management
- **Physical & Digital Products:** Product variations, digital product downloads, inventory & stock tracking.
- **Marketing & Sales Boosters:** Flash sales, coupon management, wishlist, product comparisons, and push notifications (Webpush / VAPID).

---
