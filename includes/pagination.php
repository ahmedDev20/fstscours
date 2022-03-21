<nav aria-label="Page navigation example mt-5">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page <= 1) echo 'disabled' ?>">
            <a class="page-link" href="
                <?php
                if ($page <= 1) echo '#';
                else echo "?fil=$filiere&page=" . $prev;
                ?>">Précédent</a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php if ($page == $i) echo 'active' ?>">
                <a class="page-link" href="?fil=<?= $filiere ?>&page=<?= $i; ?>"> <?= $i; ?> </a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="
                <?php
                if ($page >= $totalPages) echo '#';
                else echo "?fil=$filiere&page=" . $next;
                ?>">Suivant</a>
        </li>
    </ul>
</nav>