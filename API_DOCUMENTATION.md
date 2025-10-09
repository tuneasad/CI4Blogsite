# CI4 Blog API Documentation

This documentation provides details about the REST API for the CodeIgniter 4 Blog CMS.

## Base URL

All API endpoints are prefixed with `/api`.

-   **Production:** `https://yourdomain.com/api/`
-   **Local:** `http://localhost:8080/api/`

## Authentication

The API uses Bearer Token authentication for protected endpoints. To access these endpoints, you must include an `Authorization` header in your request with a valid access token.

-   **Header:** `Authorization: Bearer <YOUR_ACCESS_TOKEN>`

Protected endpoints are marked with a 🔒 icon.

---

## Posts

### List all published posts

-   **Endpoint:** `GET /posts`
-   **Description:** Retrieves a paginated list of all published blog posts.
-   **Success Response (200 OK):**
    ```json
    [
        {
            "id": 1,
            "title": "My First Blog Post",
            "slug": "my-first-blog-post",
            "content": "This is the content of my first blog post.",
            "category_id": 1,
            "image": "image1.jpg",
            "author_id": 1,
            "status": "Published",
            "published_at": "2023-10-27 10:00:00",
            "created_at": "2023-10-27 10:00:00",
            "updated_at": "2023-10-27 10:00:00"
        }
    ]
    ```

### Get a single post

-   **Endpoint:** `GET /posts/{id}`
-   **Description:** Retrieves a single blog post by its ID.
-   **Parameters:**
    -   `id` (integer, required): The ID of the post.
-   **Success Response (200 OK):**
    ```json
    {
        "id": 1,
        "title": "My First Blog Post",
        "slug": "my-first-blog-post",
        "content": "This is the content of my first blog post.",
        "category_id": 1,
        "image": "image1.jpg",
        "author_id": 1,
        "status": "Published",
        "published_at": "2023-10-27 10:00:00",
        "created_at": "2023-10-27 10:00:00",
        "updated_at": "2023-10-27 10:00:00"
    }
    ```
-   **Error Response (404 Not Found):**
    ```json
    {
        "status": 404,
        "error": 404,
        "messages": {
            "error": "Post not found"
        }
    }
    ```

### 🔒 Create a new post

-   **Endpoint:** `POST /posts`
-   **Description:** Creates a new blog post.
-   **Authentication:** Bearer Token required.
-   **Request Body:**
    ```json
    {
        "title": "A New Post",
        "content": "The content of the new post.",
        "category_id": 2,
        "status": "Published",
        "image_base64": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUg..."
    }
    ```
-   **Success Response (201 Created):**
    ```json
    {
        "id": 2,
        "title": "A New Post",
        ...
    }
    ```

### 🔒 Update a post

-   **Endpoint:** `PUT /posts/{id}`
-   **Description:** Updates an existing blog post.
-   **Authentication:** Bearer Token required.
-   **Parameters:**
    -   `id` (integer, required): The ID of the post to update.
-   **Request Body:**
    ```json
    {
        "title": "Updated Post Title",
        "content": "Updated content.",
        "category_id": 1
    }
    ```
-   **Success Response (200 OK):**
    ```json
    {
        "id": 2,
        "title": "Updated Post Title",
        ...
    }
    ```

### 🔒 Delete a post

-   **Endpoint:** `DELETE /posts/{id}`
-   **Description:** Deletes a blog post.
-   **Authentication:** Bearer Token required.
-   **Parameters:**
    -   `id` (integer, required): The ID of the post to delete.
-   **Success Response (200 OK):**
    ```json
    {
        "id": 2,
        "messages": {
            "success": "Post deleted successfully"
        }
    }
    ```

---

## Categories

### List all categories

-   **Endpoint:** `GET /categories`
-   **Description:** Retrieves a list of all categories.
-   **Success Response (200 OK):**
    ```json
    [
        {
            "id": 1,
            "name": "Technology",
            "slug": "technology",
            "created_at": "2023-10-27 10:00:00",
            "updated_at": "2023-10-27 10:00:00"
        },
        {
            "id": 2,
            "name": "Lifestyle",
            "slug": "lifestyle",
            "created_at": "2023-10-27 10:00:00",
            "updated_at": "2023-10-27 10:00:00"
        }
    ]
    ```
---