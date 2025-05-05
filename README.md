# Laravel 12 Blog API

A RESTful API project for managing blog posts using **Laravel 12**, focusing on advanced **Form Request validation**.

## 🚀 Tech Stack

- **Laravel 12**
- **PHP 8+**
- **MySQL**
- **Laravel Form Request**
- **Custom Validation Rules**
- **API Resource Routes**
- **JSON Responses**
- **HTTP Status Codes**

## 📌 Features

- CRUD operations for blog posts via `/api/posts`
- Use of `FormRequest` for:
  - Validation rules
  - Custom error messages
  - Attribute names
  - Pre-validation data transformation
  - Post-validation logic
  - Custom failed validation responses
- Auto-generating `slug` from `title` if not provided
- Custom validation rules for:
  - Valid slug format (lowercase letters, numbers, hyphens)
  - Future publish date
  - Maximum number of keywords
- Dynamic error messages based on input
- JSON API response structure with appropriate status codes

## 📁 Structure

- `Post` Model & Migration
- `Api\PostController`
- `StorePostRequest`, `UpdatePostRequest`
- `ValidSlug`, `FutureDate`, `KeywordsLimit` custom rules

## 📂 Postman Collection

You can test the API using the following Postman collection:

🔗 [Laravel Blog API - Postman Collection](https://api.postman.com/collections/38893521-4a4583ad-97ed-49b8-a991-4113753056df?access_key=PMAT-01JTGMYVGSNNYXVFWD2YVAGP4Z)


