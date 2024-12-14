<!DOCTYPE html>
{{-- <html lang="{{ app()->getLocale() }}" dir="{{ config('app.direction') }}"> --}}
    <html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if(isset($websiteSettings->favicon))
        <link rel="icon" type="image/png" href="{{ Storage::url($websiteSettings->favicon) }}">
        @endif

        {{-- <title>{{ $title ?? 'Default Page Title' }}</title>
        <meta property="og:locale" content="{{ app()->getLocale() }}">

        <meta name="description" content="{{ $metaDescription ?? 'Default description of the page' }}">
    <meta name="keywords" content="{{ $keywords ?? 'default, keywords, here' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Open Graph Tags for Social Sharing -->
    <meta property="og:title" content="{{ $title ?? 'Default Page Title' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Default description of the page' }}">
    <meta property="og:image" content="{{ $mainImage ?? asset('default-image.jpg') }}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="product:price:amount" content="{{ $price ?? ''}}">
    <meta property="product:price:currency" content="{{ $currency ?? '' }}">
    <meta property="product:category" content="{{ $category ?? '' }}">
    <meta property="product:brand" content="{{ $brand ?? ''}}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? ''}}">
    <meta name="twitter:description" content="{{ $metaDescription ?? '' }}">
    <meta name="twitter:image" content="{{ $mainImage ?? '' }}">

    <!-- Structured Data (JSON-LD) for Rich Snippets -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "{{ $title }}",
            "image": "{{ $mainImage }}",
            "description": "{{ $metaDescription }}",
            "sku": "{{ $product->sku ?? 'N/A' }}",
            "brand": {
                "@type": "Brand",
                "name": "{{ $brand }}"
            },
            "category": "{{ $category }}",
            "offers": {
                "@type": "Offer",
                "url": "{{ url()->current() }}",
                "priceCurrency": "{{ $currency }}",
                "price": "{{ $price }}",
                "availability": "{{ $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ $averageRating }}",
                "reviewCount": "{{ $reviewCount }}"
            }
        }
        </script> --}}

        <title>
            {{ isset($title) && isset($websiteSettings->site_name)
                ? $title . " - " . $websiteSettings->site_name
                : ($websiteSettings->site_name ?? 'Default Site Title') }}
        </title>
                <meta property="og:locale" content="{{ app()->getLocale() }}">
        <meta name="description" content="{{ $metaDescription ?? $websiteSettings->meta_description ?? 'Default description of the page' }}">
        <meta name="keywords" content="{{ $keywords ?? $websiteSettings->meta_keyword ?? 'default, keywords, here' }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Open Graph Tags for Social Sharing -->
        <meta property="og:title" content="{{ $title ?? $websiteSettings->site_name ?? 'Default Site Title' }}">
        <meta property="og:description" content="{{ $metaDescription ?? $websiteSettings->meta_description ?? 'Default description of the page' }}">
        <meta property="og:image"
        content="{{ $mainImage ?? ($websiteSettings->logo ? Storage::url($websiteSettings->logo) : asset('default-image.jpg')) }}">
          <meta property="og:type" content="{{ isset($price) ? 'product' : 'website' }}">
        <meta property="og:url" content="{{ url()->current() }}">

        <!-- Product-specific Tags (only on Product pages) -->
        @if(isset($price) && isset($currency))
            <meta property="product:price:amount" content="{{ $price }}">
            <meta property="product:price:currency" content="{{ $currency }}">
        @endif

        @if(isset($category))
            <meta property="product:category" content="{{ $category }}">
        @endif

        @if(isset($brand))
            <meta property="product:brand" content="{{ $brand }}">
        @endif

        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="{{ isset($price) ? 'summary_large_image' : 'summary' }}">
        <meta name="twitter:title" content="{{ $title ?? $websiteSettings->site_name ?? 'Default Site Title' }}">
        <meta name="twitter:description" content="{{ $metaDescription ?? $websiteSettings->meta_description ?? 'Default description of the page' }}">
        <meta name="twitter:image" content="{{ $mainImage ?? asset('default-image.jpg') }}">

        <!-- Structured Data (JSON-LD) for Product Pages -->
        @if(isset($price))
            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Product",
                    "name": "{{ $title }}",
                    "image": "{{ $mainImage }}",
                    "description": "{{ $metaDescription }}",
                    "sku": "{{ $product->sku ?? 'N/A' }}",
                    "brand": {
                        "@type": "Brand",
                        "name": "{{ $brand ?? 'Default Brand' }}"
                    },
                    "category": "{{ $category ?? 'General' }}",
                    "offers": {
                        "@type": "Offer",
                        "url": "{{ url()->current() }}",
                        "priceCurrency": "{{ $currency ?? 'USD' }}",
                        "price": "{{ $price ?? 0 }}",
                        "availability": "{{ $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
                    },
                    "aggregateRating": {
                        "@type": "AggregateRating",
                        "ratingValue": "{{ $averageRating ?? 0 }}",
                        "reviewCount": "{{ $reviewCount ?? 0 }}"
                    }
                }
            </script>
        @endif


        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'tajawal-regular', sans-serif;

    }
.rating-stars {
    display: inline-block;
    font-size: 12px; /* Adjust the size as needed */

}

.star-filled {
    color: #FFD700; /* Yellow color for filled stars */
    font-size: 12px; /* Adjust the size as needed */

}

.star-empty {
    color: #ececec; /* White background for empty stars */
    font-size: 12px; /* Adjust the size as needed */
}
.rating-stars-big {
    display: inline-block;

}
.star-filled-big {
    color: rgb(234 179 8);

}


.star-empty-big {
    color: #ececec; /* White background for empty stars */
}


.rtl-flip {
                                        transform: scaleX(-1);
                                    }
                                    .scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
                                    #testimonial-carousel.active {
    cursor: grabbing;
    cursor: -webkit-grabbing;
}
                                    .testimonials{
	background-color: #f33f02;
	position: relative;
	padding-top: 80px;
	&:after{
		content: '';
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 30%;
		background-color: #ddd;
	}

    .no-scroll {
    overflow: hidden;
}

}
#customers-testimonials {
	.item-details{
		background-color: #333333;
		color: #fff;
		padding: 20px 10px;
		text-align: left;
		h5{
			margin: 0 0 15px;
			font-size: 18px;
			line-height: 18px;
			span{
				color: red;
				float:right;
				padding-right: 20px;
			}
		}
		p{
			font-size: 14px;
		}
	}
	.item {
			text-align: center;
			// padding: 20px;
			margin-bottom:80px;
	}
}
.owl-carousel .owl-nav [class*='owl-'] {
  -webkit-transition: all .3s ease;
  transition: all .3s ease;
}
.owl-carousel .owl-nav [class*='owl-'].disabled:hover {
  background-color: #D6D6D6;
}
.owl-carousel {
  position: relative;
}
.owl-carousel .owl-next,
.owl-carousel .owl-prev {
  width: 50px;
  height: 50px;
	line-height: 50px;
	border-radius: 50%;
  position: absolute;
  top: 30%;
	font-size: 20px;
  color: #fff;
	border: 1px solid #ddd;
	text-align: center;
}
.owl-carousel .owl-prev {
  left: -70px;
}
.owl-carousel .owl-next {
  right: -70px;
}



    </style>
        @vite('resources/css/app.css')
@vite('resources/js/app.js')
        @livewireStyles()
    </head>
    <body class="bg-slate-200 dark:bg-slate-700">
        @livewire('partials.navbar')

        <main>
            {{ $slot }}
        </main>
        @livewire('partials.footer')

        @livewireScripts()

@livewireStyles
@livewireScripts


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


@stack('scripts')

<x-livewire-alert::scripts />
    </body>
</html>
