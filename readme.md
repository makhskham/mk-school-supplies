# MK’s School Supplies Store

This repository contains the full source code (PHP, JavaScript, CSS) and database schema (MySQL) for the MK’s School Supplies Store e‑commerce application.

LIVE URL LINK: https://khamzal.myweb.cs.uwindsor.ca/schoolstore/
---

## 📂 Repository Structure

```
/                     # root of repo
  ├── admin/          # admin‑side PHP scripts
  ├── assets/         # external CSS & JS
  │   ├── css/styles.css
  │   └── js/app.js
  ├── images/         # product images, icons, placeholder.png
  ├── media/          # intro_video.mp4, clap_sound.mp3, us_sound.mp3
  ├── help_*.php      # front‑end & admin help wiki pages
  ├── index.php
  ├── account.php
  ├── about.php
  ├── product.php
  ├── cart.php
  ├── checkout.php
  ├── header.php / footer.php
  ├── order_history.php
  ├── contact.php
  ├── shipping_quote.php
  ├── signup.php / login.php / logout.php / profile.php
  ├── review_submit.php
  ├── search.php
  ├── thankyou.php
  ├── test_db.php
  ├── theme_config.json
  ├── db.php          # database connection class
  ├── README.md       # this file
  ├── IMPORTANT.md    # Criteria for the project
  └── schoolstore_db.sql   # MySQL table definitions
```

---

## ⚙ Installation

1. **Clone the repository** to your web‑root:

   ```bash
   git clone https://github.com/yourusername/mk‑school‑supplies.git
   cd mk‑school‑supplies
   ```

2. **Install prerequisites**:

   - PHP 7.4+ with PDO extension
   - MySQL 5.7+ (or MariaDB)
   - Apache (or Nginx) with mod\_php

3. **Create the database**:

   ```sql
   -- in your MySQL client:
   CREATE DATABASE schoolstore_db CHARACTER SET utf8mb4;
   USE schoolstore_db;
   SOURCE schoolstore_db.sql;
   ```

4. **Configure database connection**:

   - Edit `db.php` and set your MySQL credentials:
     ```php
     private \$host = 'localhost';
     private \$dbName = 'schoolstore_db';
     private \$username = 'YOUR_DB_USER';
     private \$password = 'YOUR_DB_PASSWORD';
     ```

5. **Set file permissions** (if needed):

   ```bash
   chmod -R 755 images media assets
   chown -R www-data:www-data .
   ```

6. **Start your web server** (e.g. XAMPP, MAMP, LAMP) and navigate to:

   ```
   http://localhost/mk‑school‑supplies/index.php
   ```

---

## 🗄 Database Schema

All table definitions are in `schoolstore_db.sql`. Key tables:

- **products** (`product_id PK`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`)
- **users** (`user_id PK`, `username`, `email`, `password_hash`, `role`, `created_at`)
- **orders** (`order_id PK`, `user_id FK`, `order_date`, `total`)
- **order\_items** (`order_item_id PK`, `order_id FK`, `product_id FK`, `quantity`, `price`)
- **reviews** (`review_id PK`, `product_id FK`, `user_id FK`, `rating`, `comment`, `admin_response`, `created_at`, `updated_at`)
- **options** (`option_id PK`, `option_type`, `label`, `extra_cost`)
- **product\_options** (`id PK`, `product_id FK`, `option_id FK`)

---

## 📝 Code Documentation

- All PHP files include inline comments and [phpDoc](https://www.phpdoc.org/)‑style docblocks on classes and methods.
- JavaScript (`assets/js/app.js`) is documented with function and behavior comments.
- CSS variables and sections are clearly labeled in both inline `<style>` and `styles.css`.

---

## 🚀 Deployment & Branching

- **Main branch** (`main`) holds the production‑ready code.
- **feature/** branches for new features (e.g. `feature/interactive‑map`).
- **hotfix/** branches for urgent fixes (e.g. `hotfix/cart‑bug`).
- After cloning, checkout the desired branch:
  ```bash
  git checkout feature/your‑feature
  ```

---

## 🛠 Contributing

1. Fork the repo. 2. Create a branch (`git checkout -b feature/xyz`). 3. Commit your changes. 4. Push to your fork. 5. Open a PR.

---

## 📄 License

MIT © MK’s School Supplies Store

