# 🍽️ Food Restaurant Website in PHP

This is a full-featured **Food Restaurant Website** built in **PHP**, including three main modules: **Admin**, **User**, and **Viewer (Guest)**. The website supports image galleries, menu management, table booking, order handling, and feedback systems. It uses modern libraries and effects for an engaging user experience.

---

---

## 👥 Modules & Functionalities

### 🔐 Admin Module (`/admin`)
> 🧑‍💼 Admin credentials required

- 🖼️ **Gallery Image Management**
  - 📤 Upload images
  - 🗑️ Delete images

- 🍽️ **Menu Items CRUD**
  - ➕ Add new menu items (with image, name, price)
  - ✏️ Edit/update menu items
  - 🗑️ Delete items
  - 📋 List all menu items

- 📦 **Order Management**
  - 👀 View all user orders
  - 🔄 Update order status (Pending ✅, Confirmed ✅, Delivered ✅)
  - 🗑️ Delete orders

- 💬 **Feedback Review**
  - 📜 View all submitted feedback

---

### 👤 User Module (`/client`)
> 🔐 Registration and login required

- 🍽️ **Book a Table**
  - 📅 Select date & time
  - 👥 Choose party size
  - 👀 View bookings

- 🛒 **Buy Menu Item**
  - 📋 View available menu
  - ➕ Add to cart / order items

- 📦 **My Orders**
  - 📜 View past & current orders
  - 🔄 Track order status

- 💬 **Feedback**
  - ✍️ Submit feedback for service/food

---

### 👁️ Viewer Module (Guest - Default Access)
> 🚫 No login required

- 🍽️ Book a Table
- 💬 Submit Feedback
- 📋 View Menu
- 🖼️ Browse Gallery

---

## 💡 Libraries & Technologies Used

| 🔧 Library      | 🧩 Purpose                                |
|----------------|-------------------------------------------|
| 🐘 **PHP**      | Backend development                       |
| 🛢️ **MySQL**    | Database                                  |
| 🎨 **Bootstrap**| UI layout and responsiveness              |
| 🌀 **Swiper.js**| Image/content sliders                     |
| 🎞️ **GSAP**     | Smooth animations                         |
| 🖼️ **GLightbox**| Lightbox-style image viewer               |
| ⚠️ **SweetAlert**| Alerts and confirmation popups          |

---

## ⚙️ Setup Instructions

1. 📥 **Clone the repository**  
   ```bash
   git clone https://github.com/parivaibhav/php-project.git
   cd php-project