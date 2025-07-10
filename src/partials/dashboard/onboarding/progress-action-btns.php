<div class="card-footer bg-transparent border-0">
    <div class="pt-0 d-flex justify-content-center align-items-center gap-3">
        <button type="button" class="caret btn btn-light text-danger rounded-circle p-2 d-flex align-items-center justify-content-center d-none go-backward">
            <i class="fa fa-caret-left" aria-hidden="true"></i>
        </button>

        <div class="d-flex align-items-center gap-2">
            <span class="dot active-dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>

        <button type="button" class="caret btn btn-light text-danger rounded-circle p-2 d-flex align-items-center justify-content-center proceed-next <?= client() ? 'd-none' : '' ?>">
            <i class="fa fa-caret-right" aria-hidden="true"></i>
        </button>
    </div>
</div>