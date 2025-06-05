<div class="row">
    <div class="px-4 px-lg-5 py-3">
        <div class="col-12">
            <ul class="pagination pagination-$Sizing justify-content-center">
                <% with $PaginatedMatches %>
                    <% if $NotFirstPage %>
                        <li class="page-item">
                            <a class="page-link" href="$PrevLink" title="View the previous page"
                               aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <% end_if %>
                    <% loop $PaginationSummary(6) %>
                        <% if $CurrentBool %>
                            <li class="page-item active">
                                <a class="page-link" href="#">$PageNum</a>
                            </li>
                        <% else_if $PageNum %>
                            <li class="page-item">
                                <a class="page-link" href="$Link"
                                   title='View page $PageNum of results'>$PageNum</a>
                            </li>
                        <% else %>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">&hellip;</a>
                            </li>
                        <% end_if %>
                    <% end_loop %>
                    <% if $NotLastPage %>
                        <li class="page-item">
                            <a class="page-link" href="$NextLink" title="View the next page"
                               aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <% end_if %>
                <% end_with %>
            </ul>
        </div>
    </div>
</div>
