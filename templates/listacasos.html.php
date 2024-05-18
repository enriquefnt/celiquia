<?php
//     var_dump($variables['casos']) ;die; 
?>
<div class="container mt-4">
  <table id="example" class="table table-bordered display compact">
    <thead>
      <tr>
        <th class="text-center align-middle">Fecha</th>
        <th class="text-center">Notifica</th>
        <th class="text-center">Nombre</th>
        <th class="text-center align-middle ">Edad</th>
        <th class="text-center">Localidad</th>
        <th class="text-center">Ver/Imprimir</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <?php foreach ($variables['casos'] as $caso) : ?>
          <td><?= $caso['fechanot']; ?></td>
          <td><?= $caso['institucion']; ?></td>
          <td><?= htmlspecialchars($caso['nombres'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= $caso['edad']; ?></td>
          <td><?= $caso['localidad']; ?></td>

          <!-- <td class="text-center">
            <a href="/ficha/print?idficha=<?= $caso['idficha'] ?>&nom=<?= $caso['nombresTitulo'] ?>" target="_blank">
            <i class="fa-regular fa-file-pdf"></i> -->
          <td class="text-center">
            <a href="/ficha/print?idficha=<?= $caso['idficha'] ?>&nom=<?= $caso['nombresTitulo'] ?>" target="_blank">
              <i class="fa-regular fa-file-pdf"></i>
            </a>
          </td>
          </a>

          </td>

      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>