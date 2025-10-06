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

## 🖼 Working Screenshots

1. **Product Seeder**  
   Adding initial products to the database.

   <img width="1120" height="649" alt="product-seeder-run" src="https://github.com/user-attachments/assets/476f296f-1e21-45e9-91bc-c5882304dd1f" />
   <img width="1120" height="581" alt="product-seeder-added" src="https://github.com/user-attachments/assets/e2d9517b-12f9-4872-b658-983e2c3794d7" />
   <img width="1119" height="664" alt="product-seeder-added-01" src="https://github.com/user-attachments/assets/f61abb3d-1ea3-44f3-8ddd-5afb5c8362be" />

2. **Product Grid**  
   Display all products on the home page with pagination, showing 10 records per page.

   <img width="1120" height="664" alt="product-grid-1" src="https://github.com/user-attachments/assets/73cd8728-133f-49ee-8e6d-7c260aa43934" />
   <img width="1120" height="663" alt="product-grid-01" src="https://github.com/user-attachments/assets/c5400287-a874-4eac-869a-ddd323117956" />

3. **Login Validation (Buy Now Click)**  
   Prompt for login if the user is not logged in.

   <img width="1120" height="663" alt="login-required" src="https://github.com/user-attachments/assets/33b6b88e-e695-4551-8542-d1124a346ef1" />

4. **Register**  
   User registration page.

   <img width="1120" height="664" alt="register-page-1" src="https://github.com/user-attachments/assets/cb2e634b-4d0d-42ac-ac0f-3372c0f69dd3" />
   <img width="1119" height="664" alt="register-page-2" src="https://github.com/user-attachments/assets/303b3138-2569-4098-8cc9-a273afe436a2" />

5. **Login**  
   User login page and home page after login.

   <img width="1120" height="664" alt="login-page-1" src="https://github.com/user-attachments/assets/620536b4-3204-4b94-bfac-e023d23f09a7" />
   <img width="1120" height="664" alt="after-login-grid-1" src="https://github.com/user-attachments/assets/11ab22f1-8a57-44a6-a9db-6ffc2c0fc64a" />

6. **Inner Product Details**  
   Product detail page with Stripe checkout form.

   <img width="1120" height="663" alt="inner-product-page-1" src="https://github.com/user-attachments/assets/c6c0aeb2-b471-4a14-90e1-a18ff6601c1d" />

7. **Product Checkout with Stripe Form**  
   Product checkout with Stripe credit card form.

   <img width="1118" height="665" alt="credit-card-validation-1" src="https://github.com/user-attachments/assets/6e99b3a0-8825-4174-8f50-9ea70a5b1a00" />
   <img width="1120" height="664" alt="credit-card-validation-2" src="https://github.com/user-attachments/assets/54be9add-dcf6-4716-9487-e2e5e58b291b" />
   <img width="1120" height="662" alt="credit-card-validation-3" src="https://github.com/user-attachments/assets/6d1e2748-0909-4357-bd6f-e3c6bac817ff" />
   <img width="1120" height="664" alt="credit-card-validation-4" src="https://github.com/user-attachments/assets/549e6378-3183-4621-a21e-f5719a8c39d2" />

8. **Payment Success**  
   Payment succeeded screen.

   <img width="1120" height="663" alt="payment-success" src="https://github.com/user-attachments/assets/72941209-4631-487b-9b61-d8fbd1ca5a7c" />

9. **Payment Failed**  
   Payment failed screen.

   <img width="1120" height="665" alt="payment-failed" src="https://github.com/user-attachments/assets/ae6eec0a-09f4-4f33-9d9a-d80363abca3a" />

10. **Stripe CLI**  
    Stripe CLI is listening for webhooks.

    <img width="1120" height="662" alt="stripe-cli-1" src="https://github.com/user-attachments/assets/297b5d31-354b-48b0-94c0-4ee0b61701c0" />
    <img width="1118" height="616" alt="stripe-cli-2" src="https://github.com/user-attachments/assets/3248fce6-d504-4d3c-aa62-cb3f9fdc7ccb" />

11. **Stripe Dashboard: Transactions**  
    Showing completed payments, charged products, and tracking added for products and customers.

    <img width="1120" height="424" alt="stripe-transactions-1" src="https://github.com/user-attachments/assets/a04da0ac-48dd-4e14-8816-3771f090bfe5" />
    <img width="1120" height="632" alt="stripe-transactions-2" src="https://github.com/user-attachments/assets/8fd875d1-4c01-481a-b8ed-31d62ce97154" />

12. **Stripe Product Added**  
    Product added to the Stripe dashboard.

    <img width="1120" height="603" alt="stripe-product-added" src="https://github.com/user-attachments/assets/7f9ec96c-aa9d-4b64-b5b4-0d5fbfa0a7a1" />

13. **Stripe Customer Added**  
    Customer created in the Stripe dashboard.

    <img width="1115" height="280" alt="stripe-customer-added" src="https://github.com/user-attachments/assets/07731008-6c89-4f9c-82d7-8e30febb0181" />

