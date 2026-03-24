# Andabwa Foundation Blog

## Overview
Agricultural development platform showcasing community projects, technical documentation, and progress updates for the Lugari region.

## Features
- **Featured Projects**: Highlighted agricultural initiatives
- **Technical Documentation**: Comprehensive guides and tutorials
- **Advanced Search**: Filter by category and keywords
- **Responsive Design**: Mobile-first engineering-class UI
- **Livewire Integration**: Real-time filtering and pagination

## Tech Stack
- **Backend**: Laravel 10.x
- **Frontend**: Livewire + Tailwind CSS
- **Database**: MySQL
- **Media Management**: Laravel Media Library

## Key Components
- `blog/card.blade.php`: Article card component
- `blog/media.blade.php`: Media display component
- `blog/feed.blade.php`: Main blog feed
- `blog/show.blade.php`: Individual article view

## Installation
```bash
composer install
npm install
php artisan migrate
php artisan storage:link
php artisan serve
```

## Configuration
- Update `.env` with database credentials
- Configure media settings in `config/filesystems.php`
- Customize page settings via admin panel

## Features Breakdown

### Header Section
- Dynamic title and subtitle
- Professional badge with status indicator
- Responsive typography

### Search & Filter System
- Real-time search with debouncing
- Category filtering
- Reset functionality

### Article Display
- Featured projects grid
- Technical documentation archive
- Consistent card layout
- Hover effects and transitions

### Accessibility
- Keyboard navigation support
- Focus indicators
- Semantic HTML structure
- Screen reader friendly

## Performance
- Lazy loading images
- Optimized database queries
- Efficient pagination
- Minimal JavaScript footprint

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## License
© 2024 Andabwa Foundation. All rights reserved.

## Support
For technical support or contributions, contact the development team.
