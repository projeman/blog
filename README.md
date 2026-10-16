# sesuva/blog

Basit, bağımsız bir blog paketı. Post, Kategori ve Etiket yönetimi.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.3-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## Kurulum

```bash
composer require sesuva/blog
```

### Veritabanı Migrasyonları

```bash
php artisan migrate --path=vendor/sesuva/blog/database/migrations
```

Veya otomatik olarak:

```bash
php artisan vendor:publish --tag=sesuva-blog-migrations
php artisan migrate
```

## Kullanım

### Repository'ler ile Çalışma

```php
use Sesuva\Blog\Repositories\BlogPostRepository;
use Sesuva\Blog\Repositories\BlogCategoryRepository;
use Sesuva\Blog\Repositories\BlogTagRepository;

// Post oluştur
$postRepo = app(BlogPostRepository::class);
$post = $postRepo->create([
    'title' => 'İlk Blog Yazısı',
    'excerpt' => 'Özet...',
    'content' => 'İçerik...',
    'category_id' => 1,
    'is_published' => true,
    'published_at' => now(),
]);

// Yayınlanan postları al
$posts = $postRepo->getPublished();

// Slug ile postları ara
$post = $postRepo->findBySlug('ilk-blog-yazisi');

// Arama
$results = $postRepo->search('arama terimi');
```

### Model Kullanımı

```php
use Sesuva\Blog\Models\BlogPost;
use Sesuva\Blog\Models\BlogCategory;
use Sesuva\Blog\Models\BlogTag;

$post = BlogPost::published()
    ->where('category_id', 1)
    ->latest('published_at')
    ->get();

// Kategoriyle ilişkili postları al
$category = BlogCategory::find(1);
$posts = $category->posts()->published()->get();
```

### Veriler

**blog_categories**
- `id`
- `name` - Kategori adı
- `slug` - URL slug'ı (otomatik)
- `description` - Açıklama
- `parent_id` - Üst kategori (hierarchical)
- `image` - Kategori resmi
- `is_active` - Aktif/pasif
- `sort_order` - Sıralama
- `timestamps`

**blog_posts**
- `id`
- `category_id` - Kategori
- `title` - Başlık
- `slug` - URL slug'ı (otomatik)
- `excerpt` - Özet
- `content` - İçerik (WYSIWYG destekli)
- `featured_image` - Öne çıkan resim
- `meta_title`, `meta_description`, `meta_keywords` - SEO
- `is_published` - Yayınlanmış mı?
- `published_at` - Yayın tarihi
- `view_count` - Görüntüleme sayısı
- `timestamps`

**blog_tags**
- `id`
- `name` - Etiket adı
- `slug` - URL slug'ı (otomatik)
- `timestamps`

**blog_post_tag** (pivot)
- `post_id` - Post ID
- `tag_id` - Tag ID
- `timestamps`

## Özellikleri

- 📝 Post, Kategori, Etiket yönetimi
- 🔍 Arama ve filtreleme
- 📊 Görüntüleme sayacı
- 🏷️ Tag sistemi
- 🗂️ Kategori hiyerarşisi
- 🔐 Yayın planlama
- 📱 SEO-uyumlu

## Lisans

MIT License - Ayrıntılar için `LICENSE` dosyasına bakın.
