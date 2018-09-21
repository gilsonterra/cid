<pagination>
    <div class="container-pagination">
        <ul class="pagination float-right">
            <li if="{ opts.grid.prev_page_url }" class="page-item">
                <a href="javascript:;"onclick="{ opts.prev }" aria-label="Anterior">
                    <i class="icon icon-arrow-left"></i>
                </a>
            </li>
            <li if="{ !opts.grid.prev_page_url }" class="page-item disabled">
                <a href="javascript:;" tabindex="-1" aria-label="Anterior">
                    <i class="icon icon-arrow-left"></i>
                </a>
            </li>
            <li if="{ opts.grid.next_page_url }" class="page-item">
                <a href="javascript:;" onclick="{ opts.next }" aria-label="Próximo">
                    <i class="icon icon-arrow-right"></i>
                </a>
            </li>
            <li if="{ !opts.grid.next_page_url }" class="page-item disabled">
                <a href="javascript:;" tabindex="-1" aria-label="Próximo">
                    <i class="icon icon-arrow-right"></i>
                </a>
            </li>
        </ul>
        <div class="float-left pagination-info">
            Mostrando de { opts.grid.from || 0 } até { opts.grid.to || 0 } de { opts.grid.total } registros.
        </div>
    </div>    
</pagination>