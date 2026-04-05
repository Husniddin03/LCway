# Admin Panel API Documentation

## Umumiy ma'lumot

Barcha admin API endpoints `/api/admin` prefixi bilan boshlanadi va `auth:sanctum` hamda `admin` middleware bilan himoyalangan.

## Authentication

API dan foydalanish uchun avval login qilib, token olishingiz kerak:

```bash
POST /login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

Tokenni har bir so'rovda `Authorization: Bearer {token}` header sifatida yuborish kerak.

**Admin huquqi:** Foydalanuvchining `role` maydoni `admin` bo'lishi kerak.

---

## Dashboard Endpoints

### Statistika olish
```
GET /api/admin/dashboard/statistics
```

### So'ngi aktivliklar
```
GET /api/admin/dashboard/activities
```

### Grafik ma'lumotlari
```
GET /api/admin/dashboard/chart-data
```

---

## Users (Foydalanuvchilar) Endpoints

### Barcha foydalanuvchilar
```
GET /api/admin/users
```

**Query parametrlar:**
- `search` - Ism yoki email bo'yicha qidirish
- `role` - Rol bo'yicha filter (user, admin, moderator)
- `status` - Status bo'yicha filter (active, inactive, banned)
- `checked` - Tasdiqlangan foydalanuvchilar (0, 1)
- `sort_by` - Saralash maydoni (default: created_at)
- `sort_order` - Saralash tartibi (asc, desc)
- `per_page` - Sahifa o'lchami (default: 20)

### Bitta foydalanuvchi
```
GET /api/admin/users/{id}
```

### Foydalanuvchi yaratish
```
POST /api/admin/users
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "role": "user",
  "status": "active",
  "phone": "+998901234567",
  "avatar": "https://example.com/avatar.jpg"
}
```

### Foydalanuvchini yangilash
```
PUT /api/admin/users/{id}
Content-Type: application/json

{
  "name": "Updated Name",
  "status": "inactive"
}
```

### Foydalanuvchini o'chirish
```
DELETE /api/admin/users/{id}
```

### Foydalanuvchi statusini almashtirish
```
POST /api/admin/users/{id}/toggle-status
```

### Mass yangilash
```
POST /api/admin/users/bulk-update
Content-Type: application/json

{
  "ids": [1, 2, 3],
  "status": "active",
  "role": "moderator"
}
```

### Mass o'chirish
```
POST /api/admin/users/bulk-delete
Content-Type: application/json

{
  "ids": [1, 2, 3]
}
```

---

## Learning Centers (O'quv Markazlari) Endpoints

### Barcha markazlar
```
GET /api/admin/centers
```

**Query parametrlar:**
- `search` - Nomi, tavsifi yoki manzil bo'yicha qidirish
- `checked` - Tasdiqlangan (0, 1)
- `premium` - Premium (0, 1)
- `region_id` - Viloyat bo'yicha filter
- `district_id` - Tuman bo'yicha filter
- `sort_by`, `sort_order`, `per_page`

### Bitta markaz
```
GET /api/admin/centers/{id}
```

### Markaz yaratish
```
POST /api/admin/centers
Content-Type: application/json

{
  "name": "Najot Ta'lim",
  "description": "Dasturlash kurslari",
  "address": "Toshkent, Chilonzor",
  "phone": "+998901234567",
  "email": "info@najottalim.uz",
  "website": "https://najottalim.uz",
  "telegram": "@najottalim",
  "region_id": 1,
  "district_id": 2,
  "users_id": 1
}
```

### Markazni yangilash
```
PUT /api/admin/centers/{id}
```

### Markazni o'chirish
```
DELETE /api/admin/centers/{id}
```

### Tasdiqlashni almashtirish
```
POST /api/admin/centers/{id}/toggle-verification
```

### Premium statusni almashtirish
```
POST /api/admin/centers/{id}/toggle-premium
```

### Tasdiqlanishini kutilayotgan markazlar
```
GET /api/admin/centers-pending
```

### Markaz statistikasi
```
GET /api/admin/centers-statistics
```

### Rasmni o'chirish
```
DELETE /api/admin/center-images/{imageId}
```

---

## Teachers (O'qituvchilar) Endpoints

### Barcha o'qituvchilar
```
GET /api/admin/teachers
```

**Query parametrlar:**
- `search` - Ism, telefon yoki email bo'yicha
- `center_id` - Markaz bo'yicha filter

### Bitta o'qituvchi
```
GET /api/admin/teachers/{id}
```

### O'qituvchi yaratish
```
POST /api/admin/teachers
Content-Type: application/json

{
  "name": "Ali Valiyev",
  "phone": "+998901234567",
  "email": "ali@example.com",
  "bio": "Senior dasturchi",
  "learning_center_id": 1
}
```

### O'qituvchini yangilash
```
PUT /api/admin/teachers/{id}
```

### O'qituvchini o'chirish
```
DELETE /api/admin/teachers/{id}
```

### Mass o'chirish
```
POST /api/admin/teachers/bulk-delete
Content-Type: application/json

{
  "ids": [1, 2, 3]
}
```

### O'qituvchi statistikasi
```
GET /api/admin/teachers-statistics
```

---

## Subjects (Fanlar) Endpoints

### Barcha fanlar
```
GET /api/admin/subjects
```

**Query parametrlar:**
- `search` - Nomi bo'yicha qidirish
- `center_id` - Markaz bo'yicha filter

### Bitta fan
```
GET /api/admin/subjects/{id}
```

### Fan yaratish
```
POST /api/admin/subjects
Content-Type: application/json

{
  "name": "PHP Dasturlash",
  "description": "Backend dasturlash kursi",
  "price": 1500000,
  "duration": "3 oy",
  "learning_center_id": 1
}
```

### Fanni yangilash
```
PUT /api/admin/subjects/{id}
```

### Fanni o'chirish
```
DELETE /api/admin/subjects/{id}
```

### Mass o'chirish
```
POST /api/admin/subjects/bulk-delete
```

### Fan statistikasi
```
GET /api/admin/subjects-statistics
```

---

## Comments (Izohlar) Endpoints

### Barcha izohlar
```
GET /api/admin/comments
```

**Query parametrlar:**
- `search` - Matn bo'yicha qidirish
- `checked` - Tasdiqlangan (0, 1)
- `center_id` - Markaz bo'yicha
- `user_id` - Foydalanuvchi bo'yicha

### Bitta izoh
```
GET /api/admin/comments/{id}
```

### Izohni yangilash
```
PUT /api/admin/comments/{id}
Content-Type: application/json

{
  "comment": "Yangi matn",
  "rating": 5,
  "checked": true
}
```

### Izohni o'chirish
```
DELETE /api/admin/comments/{id}
```

### Izohni tasdiqlash
```
POST /api/admin/comments/{id}/approve
```

### Izohni rad etish
```
POST /api/admin/comments/{id}/reject
```

### Mass tasdiqlash
```
POST /api/admin/comments/bulk-approve
Content-Type: application/json

{
  "ids": [1, 2, 3]
}
```

### Mass o'chirish
```
POST /api/admin/comments/bulk-delete
```

### Tasdiqlanishini kutilayotgan izohlar
```
GET /api/admin/comments-pending
```

### Izoh statistikasi
```
GET /api/admin/comments-statistics
```

---

## Response Format

Barcha API responses quyidagi formatda qaytariladi:

### Muvaffaqiyatli response:
```json
{
  "success": true,
  "data": { ... }
}
```

### Xatolik response:
```json
{
  "success": false,
  "message": "Xatolik matni"
}
```

### Validation xatolik:
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field": ["Xatolik matni"]
  }
}
```

---

## Pagination Format

Paginated responses:

```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [...],
    "first_page_url": "...",
    "from": 1,
    "last_page": 10,
    "last_page_url": "...",
    "next_page_url": "...",
    "path": "...",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 200
  }
}
```

---

## Papka strukturasi

```
app/
├── Http/
│   ├── Controllers/Admin/
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── LearningCenterController.php
│   │   ├── TeacherController.php
│   │   ├── SubjectController.php
│   │   └── CommentController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   ├── Requests/Admin/
│   │   ├── StoreUserRequest.php
│   │   ├── UpdateUserRequest.php
│   │   ├── StoreLearningCenterRequest.php
│   │   ├── UpdateLearningCenterRequest.php
│   │   ├── StoreTeacherRequest.php
│   │   ├── UpdateTeacherRequest.php
│   │   ├── StoreSubjectRequest.php
│   │   ├── UpdateSubjectRequest.php
│   │   ├── UpdateCommentRequest.php
│   │   └── BulkActionRequest.php
│   └── Resources/Admin/
│       ├── UserResource.php
│       ├── LearningCenterResource.php
│       ├── TeacherResource.php
│       ├── SubjectResource.php
│       ├── CommentResource.php
│       └── DashboardStatResource.php
└── routes/
    └── api.php (admin routes qo'shilgan)
```

---

## Foydalanish misoli (JavaScript/Axios)

```javascript
// Admin statistikani olish
const getStats = async () => {
  const response = await axios.get('/api/admin/dashboard/statistics', {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  });
  return response.data;
};

// Foydalanuvchilarni olish
const getUsers = async (page = 1, search = '') => {
  const response = await axios.get('/api/admin/users', {
    params: { page, search, per_page: 20 },
    headers: { 'Authorization': `Bearer ${token}` }
  });
  return response.data;
};

// Markazni tasdiqlash
const verifyCenter = async (id) => {
  const response = await axios.post(`/api/admin/centers/${id}/toggle-verification`, {}, {
    headers: { 'Authorization': `Bearer ${token}` }
  });
  return response.data;
};
```
