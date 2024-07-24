For creating a standard template for commit messages, use the structure below:

<type>: <short summary>
<detailed description>
<additional notes, if any>

Where `<type>` could be:

- `add`: for new features or files
- `impl`: for implementations of existing features
- `improve`: for improvements or optimizations
- `fix`: for bug fixes
- `refactor`: for code refactoring
- `docs`: for documentation changes
- `test`: for adding or modifying tests

Examples:

1. Adding new functions:
```
add: Implement user authentication functions

- Create login() function
- Add logout() function
- Implement password hashing utility

These functions provide a secure way to manage user sessions.
```

2. Implementing a feature:
```
impl: Complete user registration process

- Add form validation
- Implement email verification
- Create user profile upon successful registration

This completes the user onboarding flow as per issue #123.
```

3. Improving existing functionality:
```
improve: Optimize database queries for user listing

- Add indexing to frequently queried columns
- Implement pagination for large result sets
- Cache common query results

These changes significantly reduce page load times for user listings.
```

