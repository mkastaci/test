<?php echo view('layout.header'); ?>

<div class="col-12">
    <a href="<?php echo route('admin'); ?>" class="btn btn-primary">Admin</a>
</div>
<div class="col-12">
    <a href="<?php echo route('home'); ?>?order=name" class="btn btn-primary">Trier par nom</a>&nbsp;
    <a href="<?php echo route('home'); ?>?order=editor" class="btn btn-info">Trier par éditeur</a>&nbsp;
    <!-- TODO (optionnel) n'afficher ce bouton que s'il y a un tri -->
    <a href="<?php echo route('home'); ?>" class="btn btn-dark">Annuler le tri</a><br>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">&Eacute;diteur</th>
                <th scope="col">Date de sortie</th>
                <th scope="col">Console / Support</th>
            </tr>
        </thead>
        <tbody>
            <!-- TODO boucler sur le tableau $videogameList contenant tous les jeux vidéos
        (et donc supprimer ces 2 lignes d'exemple) -->
            <?php foreach ($videogameList as $videogame) : ?>
            <tr>
                <td><?php echo $videogame->id; ?></td>
                <td><?php echo $videogame->name; ?></td>
                <td><?php echo $videogame->editor; ?></td>
                <td><?php echo $videogame->release_date; ?></td>
                <td><?php echo $videogame->platform_id; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo view('layout.footer'); ?>
