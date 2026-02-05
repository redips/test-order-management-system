# Contributing to Order Management System

Thank you for considering contributing to the Order Management System! This document provides guidelines and instructions for contributing.

## Code of Conduct

- Be respectful and inclusive
- Welcome newcomers and encourage diverse perspectives
- Focus on constructive feedback
- Respect differing viewpoints and experiences

## How to Contribute

### Reporting Bugs

Before creating bug reports, please check existing issues. When creating a bug report, include:

- Clear and descriptive title
- Exact steps to reproduce the problem
- Expected behavior
- Actual behavior
- Screenshots if applicable
- Environment details (OS, Docker version, etc.)

**Bug Report Template:**
```markdown
**Description:**
Brief description of the bug

**Steps to Reproduce:**
1. Step one
2. Step two
3. ...

**Expected Behavior:**
What should happen

**Actual Behavior:**
What actually happens

**Environment:**
- OS: [e.g., macOS 13.0, Windows 11, Ubuntu 22.04]
- Docker Version: [e.g., 24.0.5]
- Browser: [e.g., Chrome 120.0]
```

### Suggesting Features

Feature suggestions are welcome! Please include:

- Clear and descriptive title
- Detailed description of the proposed feature
- Rationale/use case
- Examples or mockups if applicable

### Pull Requests

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Commit your changes (`git commit -m 'Add amazing feature'`)
5. Push to the branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request

## Development Guidelines

### Setting Up Development Environment

1. Clone the repository:
```bash
git clone <repository-url>
cd order-management-system
```

2. Start the development environment:
```bash
make setup-with-data
```

Or manually:
```bash
docker-compose up -d --build
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### Coding Standards

#### PHP

- Follow PSR-12 coding standards
- Use Symfony coding standards
- Run PHP CS Fixer before committing:

```bash
make lint-fix
# or
docker-compose exec php composer lint:fix
```

#### JavaScript

- Use ES6+ features
- Use meaningful variable names
- Add comments for complex logic
- Keep functions small and focused

#### Twig Templates

- Use consistent indentation (4 spaces)
- Keep templates clean and readable
- Extract reusable components
- Use proper HTML5 semantics

### Design Patterns

Follow these design patterns used in the project:

- **MVC**: Separate concerns between Model, View, and Controller
- **Repository Pattern**: Use repositories for data access
- **Dependency Injection**: Inject dependencies via constructor
- **SOLID Principles**: Follow all SOLID principles

### Naming Conventions

#### PHP
- Classes: `PascalCase`
- Methods: `camelCase`
- Properties: `camelCase`
- Constants: `UPPER_SNAKE_CASE`

#### Database
- Tables: `snake_case`
- Columns: `snake_case`
- Foreign Keys: `tablename_id`

#### Twig
- Templates: `kebab-case.html.twig`
- Blocks: `snake_case`

### Testing

All code must be tested before submission.

#### Writing Tests

1. Unit tests for repositories and entities
2. Integration tests for API endpoints
3. Test edge cases and error conditions

#### Running Tests

```bash
make test
# or
docker-compose exec php composer test
```

#### Test Coverage

Aim for at least 80% code coverage.

```bash
docker-compose exec php php bin/phpunit --coverage-html coverage
```

### Commit Messages

Follow conventional commit format:

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(order): add order filtering by date range

Added date range filter to order listing page.
Users can now filter orders by creation date.

Closes #123
```

```
fix(api): fix order total calculation

Fixed bug where order total was not including all products.

Fixes #456
```

### Documentation

- Update README.md for new features
- Update API_DOCUMENTATION.md for API changes
- Add inline comments for complex logic
- Update PHPDoc blocks for methods and classes

### Database Changes

For database schema changes:

1. Create a new migration:
```bash
docker-compose exec php php bin/console make:migration
```

2. Review the generated migration
3. Test the migration:
```bash
docker-compose exec php php bin/console doctrine:migrations:migrate
```

4. Update fixtures if needed

### Pull Request Process

1. **Before Submitting:**
   - Run tests: `make test`
   - Run linter: `make lint-fix`
   - Update documentation
   - Test manually in browser

2. **PR Description:**
   - Describe what changes you made
   - Reference related issues
   - Include screenshots for UI changes
   - List breaking changes if any

3. **Review Process:**
   - Address review comments
   - Keep PR focused and small
   - Update PR based on feedback
   - Squash commits if requested

### Code Review Guidelines

When reviewing code:

- Be constructive and respectful
- Focus on code, not the person
- Suggest improvements, don't demand
- Approve when standards are met
- Request changes if needed

## Project Structure

```
order-management-system/
├── config/           # Configuration files
├── migrations/       # Database migrations
├── public/          # Public web files
├── src/
│   ├── Controller/  # Controllers (Web & API)
│   ├── Entity/      # Database entities
│   ├── Repository/  # Data repositories
│   └── DataFixtures/# Sample data
├── templates/       # Twig templates
├── tests/          # Test files
└── docker/         # Docker configuration
```

## Getting Help

- Check existing documentation
- Review closed issues
- Ask in discussions
- Contact maintainers

## Recognition

Contributors will be recognized in:
- CONTRIBUTORS.md file
- Release notes
- Project README

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

## Questions?

Feel free to:
- Open an issue for discussion
- Contact project maintainers
- Join community discussions

Thank you for contributing! 🎉
