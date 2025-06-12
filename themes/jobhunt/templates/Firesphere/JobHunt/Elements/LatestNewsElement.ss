<section class="$Type projects-section " id="e$ID">
    <main class="py-3 px-md-5 px-4 px-lg-5 container">
        <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col">
                <div class="featured-text $TextClass text-lg-left">
                    <% if $ShowTitle %>
                        <h3>$Title</h3>
                    <% end_if %>
                    <div class="text-black-50 mb-0">
                        <ul class="list-group list-group-flush">
                            <% loop $News %>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="$Link" title="$Title" class="d-flex">
                                        $FeaturedImage.FocusFill(50,50)
                                        <span class="ps-1">$Title</span>
                                    </a>
                                    <span class="align-right">
                                    $PublishDate.Nice
                                    </span>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>
