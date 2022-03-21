<div class="clearfix">
    <div class="hint-text">
        Affichage
        <?php if ($currentRecords < 2) echo "d'une entrée";
        else echo "de <b>$currentRecords</b> entrées" ?> sur <b>6</b>
    </div>
    <ul class="pagination">
        <li class="page-item <?php if ($page <= 1)  echo 'disabled'; ?>">
            <a class="page-link" href="
                    <?php
                    if ($page <= 1) echo '#';
                    else echo "?table=$table&page=$prev";
                    ?>">Précédent
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                <a class="page-link" href="index.php?table=<?= $table ?>&page=<?= $i ?>"> <?= $i; ?> </a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="
                <?php
                if ($page >= $totalPages) echo '#';
                else echo "?table=$table&page=$next";
                ?>">Suivant</a>
        </li>
    </ul>
</div>