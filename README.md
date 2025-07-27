# 🗳️ Fanap Poll System

A full-featured polling system built with Laravel 12 using clean Service Layer and Repository Pattern architecture. Includes an admin panel for poll management, user voting system, Persian date support, and result visualization.

---

## 🚀 Features

- 🧑‍💻 **User Voting System** (single-option vote per user)
- 📊 **Display Poll Results** with percentage bars
- 🗓️ **Persian Date Picker** using [PersianDatepicker](https://github.com/behzadi/persianDatepicker)
- 🛠️ **Admin Panel** for creating/editing polls and options
- ✅ **Form Validation** via Laravel Form Request classes
- 🎨 **Responsive UI** built with Tailwind CSS
- 🧱 **Clean Architecture** using Repository Pattern + Service Layer
- 🌐 Fully localized in Persian

---

## 🧰 Tech Stack

- Laravel 12
- PHP 8.3
- Laravel Sail (Docker)
- MySQL
- Tailwind CSS
- Alpine.js (optional)
- jQuery + PersianDatepicker

---

## ⚙️ Getting Started with Laravel Sail

### 1. Clone the repository

```bash
git clone https://github.com/majidmalekan/fanap.git
cd fanap
```

### 2. Install dependencies

```bash
composer install
```

### 3. Start Docker containers

```bash
./vendor/bin/sail up -d
```

### 4. Configure environment

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

Set the following in `.env`:

```
DB_HOST=mysql
APP_URL=http://localhost
```

### 5. Run migrations

```bash
./vendor/bin/sail artisan migrate
```
### 5. Run Seed For Admin And User Creation 

```bash
./vendor/bin/sail artisan db:seed
```
---

## 🧪 Sample Admin Panel Features

- Create/Edit/Delete polls
- Set start/end datetime (with Jalali calendar)
- Add/remove/edit options dynamically
- Validation for required fields and option count

---

## 🗳️ User Panel Features

- See active polls
- Vote once per poll
- View results as percentage bars (after voting)
- Persian calendar support

---

## 🧱 Architecture Overview

- `App\Services\PollService` handles business logic
- `App\Repositories\Poll\PollRepositoryInterface` defines poll data access
- `App\Http\Requests\*Request.php` for clean validation
- Blade components + Tailwind CSS for clean UI
- All logic cleanly separated into service/repo layers

---

## 🐳 Requirements

- Only **Docker** required — Laravel Sail handles the rest

---

## 💡 Usage Notes

- PersianDatepicker handles Jalali input → converted to Gregorian for backend
- Options are managed dynamically with JS in both create/edit forms
- Polls auto-detect if a user has voted and show appropriate UI

---

## 👨‍💻 Author

Developed with ❤️ by [Majid Malekan](https://github.com/majidmalekan)
