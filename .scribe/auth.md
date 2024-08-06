# Authenticating requests

To authenticate requests, include a **`Authorization`** header with the value **`"null"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Authentication for this API is managed through Laravel Breeze, a simple and minimal authentication package for Laravel.

**To authenticate:**
1. **Register**: Use the `/register` endpoint to create a new account.
2. **Login**: Use the `/login` endpoint with your credentials to obtain a session. 
   You will need to include the `Authorization` header with the token received upon successful login for subsequent API requests.
3. **Logout**: Use the `/logout` endpoint to end your session.

After logging in, Laravel Breeze will set a session cookie which can be used for authentication in subsequent requests. For API calls, ensure the `Authorization` header is included with your requests.

For more details on how to use Laravel Breeze for authentication, refer to the [Laravel Breeze documentation](https://laravel.com/docs/8.x/starter-kits#laravel-breeze).
