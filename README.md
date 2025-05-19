# Hotel Room Reservation and Service System

A comprehensive hotel management system built with Laravel, focusing on streamlining hotel operations and enhancing guest experience.

## Core Features

### 1. Room Management
- **Room Booking System**
  - Real-time availability checking
  - Calendar-based booking interface
  - Room type and preference selection
  - Booking modification and cancellation

- **Room Status Tracking**
  - Current occupancy status
  - Cleaning and maintenance status
  - Room type and features display

### 2. Guest Services
- **Check-in/Check-out Processing**
  - Digital registration process
  - Key card management
  - Express check-out option
  - Late check-out requests

- **Room Service Management**
  - Service request handling
  - Special requirements tracking
  - Real-time request status updates
  - Housekeeping schedule management

### 3. Financial Management
- **Billing and Payments**
  - Automated billing system
  - Multiple payment method support
  - Invoice generation
  - Deposit handling

- **Revenue Reporting**
  - Daily/monthly revenue reports
  - Occupancy rate analysis
  - Service usage statistics
  - Financial forecasting

### 4. Customer Relationship
- **Loyalty Program**
  - Points accumulation system
  - Member tier management
  - Special offers for members
  - Points redemption tracking

- **Discount Management**
  - Seasonal promotions
  - Group booking discounts
  - Corporate rate management
  - Special package deals

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript, TailwindCSS
- **Backend**: Laravel PHP Framework
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **UI Components**: Livewire

## Color Palette

The system uses a warm, welcoming color scheme:
- Main Background: `#F5EBDD`
- Secondary/Cards: `#EFD6D2`
- Buttons/Accents: `#D4BFAA`
- Highlights: `#C19A8B`
- Text: `#3F3F3F`
- Clean Areas: `#FAF9F6`

## User Roles

1. **Admin**
   - Full system access
   - Staff management
   - System configuration
   - Report generation

2. **Receptionist**
   - Booking management
   - Guest check-in/out
   - Room service coordination
   - Payment processing

3. **Customer**
   - Room booking
   - Service requests
   - Account management
   - Loyalty program access

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Installation
1. Clone the repository
```bash
git clone [repository-url]
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM packages
```bash
npm install
```

4. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```

5. Run migrations and seeders
```bash
php artisan migrate --seed
```

6. Start the development server
```bash
php artisan serve
npm run dev
```

## License

[MIT License](LICENSE.md)

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.
