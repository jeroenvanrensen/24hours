<x-card
    :link="route('links.show', $item)"
    :image="$item->image ?? $item->default_image"
    :altText="$item->title" 
    :title="$item->title"
    :description="$item->host"
    target="_blank"
/>
