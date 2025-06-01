<header id="e$ID"
        class="masthead <% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>"
        style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 75%, #000 100%), url('$File.Link')">
    <div class="my-5 py-5 px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <h1 class="mx-auto my-0 text-uppercase">$Title</h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5">$SubTitle</h2>
                <div class="col-md-8 offset-md-2 col-12 text-white">
                $Content
                </div>
            </div>
        </div>
    </div>
</header>
