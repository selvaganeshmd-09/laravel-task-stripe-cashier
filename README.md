# 💼 Sumanas Technologies: Laravel Assessment Task

## ⚙️ Technology Stack

-   **Laravel Framework (v8.x)**
-   **PHP Version 8.1.6**
-   **Laravel Cashier (Stripe)**
-   **Stripe API**
-   **Bootstrap 5**
-   **MySQL**

---

## 🚀 Project Flow

### 🧱 1. Product Seeder

-   Products are inserted using **Laravel Seeder + Factory**.
-   During seeding, each product is **automatically added to Stripe** with a corresponding **price** using **Laravel Cashier**.

### 🏠 2. Default Page

-   Displays all products on the **home page**.

### 🔐 3. Login Requirement

-   If a user clicks **"Buy Now"** without logging in, a **prompt alert** appears asking the user to log in.
-   Implemented login page using **Laravel Auth** with **Bootstrap 5 UI**.

### 🧮 4. Product Grid

-   Products are shown in a **grid view**.
-   Pagination limit: **10 products per page**.
-   If no product exists in the database, shows a **"No product" alert** on the page.

### 📄 5. Product Details Page

-   Displays full product details.
-   Includes a **Stripe checkout form** for payment.

### 💳 6. Purchase Process

-   Users can buy a product by clicking **"Pay Now"**.
-   Payment is processed through **Stripe** using **Laravel Cashier**.

### 🧾 7. Credit Card Validation

-   The card details are validated before making the charge.
-   Stripe test card example: `4242 4242 4242 4242`.

### ⚡ 8. Stripe Charge

-   The selected product is charged using Stripe.
-   The system records **product** and **customer details** during payment using **Stripe Cashier**.

### ✅ 9. Success Page

-   Redirects the user to a **success page** after successful payment.
-   User can navigate back to the **product page** from here.

### ❌ 10. Error Handling

-   If any issue occurs during payment, the user is redirected to an **error page**.
-   User can navigate back to the **product page** from here.

---

### 🔧 .env Configuration

Additionally, update the following in your `.env` file:

```env
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
```
