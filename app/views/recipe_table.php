<?php $v->layout('_theme_admin'); ?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Título</th>
      <th scope="col">Curtidas</th>
      <th scope="col">Tempo de Preparo (min)</th>
      <th scope="col">Tempo de Cozimento (min)</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
<?php if (isset($table)): ?>      
<?php foreach($table as $row): ?>
    <tr>
      <th scope="row"><?= $row->id ?></th>
      <td><?= $row->titulo ?></td>
      <td><?= $row->nota ?></td>
      <td><?= $row->tempo_preparo ?></td>
      <td><?= $row->tempo_cozimento ?></td>
      <td>
        <a class="btn btn-outline-info" href="<?= url('admin/receita/form/'.$row->id) ?>" 
            role="button">Alterar</a>
      </td>
      <td>
        <a class="btn btn-outline-danger" href="<?= url('admin/receita/apagar/'.$row->id) ?>" 
            role="button">Apagar</a>
      </td>
    </tr>
<?php endforeach ?>
<?php endif ?>
  </tbody>
</table>