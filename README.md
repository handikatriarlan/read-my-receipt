# Read My Receipt 📄🔍

A Laravel-based receipt OCR (Optical Character Recognition) application that automatically extracts and parses receipt information using advanced AI technology.

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.x-yellow.svg)](https://filamentphp.com)

## ✨ Features

- 📸 **Image Upload**: Upload receipt images in various formats
- 🔍 **OCR Processing**: Extract text from receipt images using Tesseract OCR
- 🤖 **AI-Powered Parsing**: Parse extracted text into structured data using Cohere AI
- 💰 **Expense Management**: Organize and manage expense records
- 🗂️ **Item Tracking**: Detailed breakdown of receipt items with quantities and prices
- 🎨 **Modern Admin Panel**: Built with Filament for a beautiful and intuitive interface
- 📊 **Data Analytics**: Track and analyze your spending patterns
- 🌍 **Multi-language OCR**: Support for Indonesian and English text recognition

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Admin Panel**: Filament 4.x
- **OCR Engine**: Tesseract OCR via `thiagoalessio/tesseract_ocr`
- **AI Integration**: Cohere AI for text parsing and structuring
- **Frontend**: Tailwind CSS with Vite
- **Database**: MySQL/PostgreSQL (configurable)
- **Queue System**: Laravel Queues for background processing

## 🏗️ Architecture

The application follows a clean architecture pattern with the following key components:

- **OCR Service** (`app/Services/OCRService.php`): Handles image-to-text extraction
- **AI Parser Service** (`app/Services/AIParserService.php`): Processes extracted text with Cohere AI
- **AI Parser Job** (`app/Jobs/AIParserJob.php`): Queued job for background AI processing
- **Models**: `Expense` and `ExpenseItem` for data persistence
- **Filament Resources**: Admin panel for expense management

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- Tesseract OCR installed on your system
- Cohere AI API key

### Step 1: Install Tesseract OCR

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install tesseract-ocr tesseract-ocr-ind tesseract-ocr-eng
```

**macOS:**
```bash
brew install tesseract tesseract-lang
```

**Windows:**
Download and install from [GitHub Tesseract releases](https://github.com/UB-Mannheim/tesseract/wiki)

### Step 2: Clone and Setup

```bash
# Clone the repository
git clone https://github.com/handikatriarlan/read-my-receipt.git
cd read-my-receipt

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Configure Environment

Edit your `.env` file with the following configurations:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=read_my_receipt
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cohere AI Configuration
COHERE_API_KEY=your_cohere_api_key_here

# Queue Configuration (for background processing)
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=local
```

### Step 4: Database Setup

```bash
# Run database migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed
```

### Step 5: Build Assets

```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### Step 6: Create Admin User

```bash
# Create a Filament admin user
php artisan make:filament-user
```

## 🎯 Usage

### Starting the Application

1. **Start the Laravel development server:**
   ```bash
   php artisan serve
   ```

2. **Start the queue worker** (for background AI processing):
   ```bash
   php artisan queue:work
   ```

3. **Access the admin panel:**
   Navigate to `http://localhost:8000/admin` and login with your admin credentials.

### Processing Receipts

1. **Upload Receipt**: Click "New Expense" in the admin panel
2. **Add Details**: Fill in the title and upload your receipt image
3. **Automatic Processing**: The system will automatically:
   - Extract text using OCR
   - Parse the data with Cohere AI
   - Structure the information into expense items
4. **Review & Edit**: Verify and adjust the extracted data as needed

## 📁 Project Structure

```
app/
├── Filament/                    # Filament admin panel resources
│   └── Resources/
│       └── Expenses/
├── Http/Controllers/            # HTTP controllers
├── Jobs/
│   └── AIParserJob.php         # Background AI processing job
├── Models/
│   ├── Expense.php             # Main expense model
│   ├── ExpenseItem.php         # Individual receipt items
│   └── User.php                # User authentication
└── Services/
    ├── AIParserService.php     # Cohere AI integration
    ├── OCRService.php          # Tesseract OCR service
    └── Helper.php              # Utility functions
```

## 🔧 Configuration

### OCR Configuration

The OCR service supports multiple languages. You can modify the language settings in `app/Services/OCRService.php`:

```php
return (new TesseractOCR($path)
    ->lang('ind+eng')  // Indonesian + English
    ->run()
);
```

### AI Parser Customization

Customize the AI parsing prompts in `app/Services/AIParserService.php` to match your specific receipt formats and requirements.

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📋 Requirements

- PHP ^8.2
- Laravel ^12.0
- Filament ^4.0
- Tesseract OCR
- Cohere AI API access

## 🔒 Security

If you discover any security vulnerabilities, please email the maintainers directly rather than creating a public issue.

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com) - The web framework
- [Filament](https://filamentphp.com) - Admin panel framework
- [Tesseract OCR](https://github.com/tesseract-ocr/tesseract) - OCR engine
- [Cohere AI](https://cohere.ai) - AI text processing
- [thiagoalessio/tesseract_ocr](https://github.com/thiagoalessio/tesseract_ocr) - PHP Tesseract wrapper

