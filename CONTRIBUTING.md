# Contributing to Route Resource Paths Laravel

Thank you for considering contributing to the Route Resource Paths Laravel package! This document provides guidelines and instructions for contributing.

## Code of Conduct

By participating in this project, you are expected to uphold our Code of Conduct. Please report unacceptable behavior to amdadulhaq781@gmail.com.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues as you might find that the problem has already been reported.

When creating a bug report, include as much detail as possible:

- Use a clear and descriptive title
- Describe the exact steps to reproduce the problem
- Provide specific examples to demonstrate the steps
- Describe the behavior you observed and what you expected
- Mention your Laravel and PHP version
- Include any relevant code snippets or error messages

### Suggesting Enhancements

Enhancement suggestions are welcome! Before suggesting, please check if the feature has already been suggested.

When suggesting an enhancement, include:

- Use a clear and descriptive title
- Provide a detailed description of the suggested enhancement
- Explain why this enhancement would be useful to most users
- Provide examples of how the enhancement would be used
- List some implementation ideas if applicable

### Pull Requests

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

#### Development Setup

1. Fork the repository
2. Clone your fork locally
3. Install dependencies: `composer install`
4. Create a feature branch: `git checkout -b my-feature-branch`

#### Coding Standards

This project uses Laravel Pint for code formatting. Before submitting a pull request, run:

```bash
composer lint
```

Ensure all code passes the linting process.

#### Making Changes

1. Make your changes following the existing code style
2. Test your changes thoroughly
3. Run the linter to ensure code style compliance
4. Commit your changes with a clear commit message
5. Push to your fork and submit a pull request

#### Commit Message Format

Follow conventional commit messages:

- `feat:` for new features
- `fix:` for bug fixes
- `docs:` for documentation changes
- `style:` for code style changes (formatting, etc.)
- `refactor:` for code refactoring
- `test:` for adding tests
- `chore:` for maintenance tasks

Example: `feat: add support for nested resource paths`

#### Testing

If you add new functionality, please ensure it works as expected and doesn't break existing functionality. Test across different Laravel versions when applicable.

## Development Workflow

1. **Fork and Clone**
   ```bash
   git clone https://github.com/YOUR_USERNAME/route-resource-paths-laravel.git
   cd route-resource-paths-laravel
   composer install
   ```

2. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make Changes and Test**
   - Write your code
   - Test thoroughly
   - Run `composer lint` to ensure code style

4. **Commit**
   ```bash
   git add .
   git commit -m "feat: your feature description"
   ```

5. **Push and Create Pull Request**
   ```bash
   git push origin feature/your-feature-name
   ```

   Then create a pull request on GitHub with:
   - Clear description of changes
   - Reference any related issues
   - Screenshots if applicable

## Style Guide

- Follow PSR-12 coding standards
- Use Laravel conventions
- Keep code simple and readable
- Add appropriate type hints
- Maintain existing code structure
- Remove unnecessary comments

## Documentation

If your changes affect the package's functionality:

- Update the README.md if needed
- Add examples for new features
- Update the API reference section
- Consider adding comments for complex logic

## Questions?

Feel free to open an issue for any questions about contributing!

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
