<?php


return[
    'edit.tab1'=>'Edición de parámetros del sistema',
    'edit.tab2'=>'Acciones del sistema',
    'edit.dashboard'=>'Tablón de Estadísticas',
    'success'=>'Parámetros del sistema modificados correctamente.',
    'error'=>'Se ha producido un error al modificar los parámetros del sistema.',
    'increment.success'=>'La máquina de estados ha sido incrementada correctamente.',
    'increment.error'=>'Se ha producido un error al incrementar el estado.',
    'state.actual'=>'Estado Actual',
    'state.next'=>'Siguiente Estado',
    'state.go'=>'Ir',


    'state.0.title'=>'Inscripciones Abiertas.',
    'state.1.title'=>'Primeras Adjudicaciones Computadas.',
    'state.2.title'=>'Adjudicación Final Computada.',
    'state.3.title'=>'Matrículas Abiertas.',
    'state.4.title'=>'Matrículas Cerradas. Asignaciones de grupos.',
    'state.5.title'=>'Permutaciones de estudiantes.',
    'state.6.title'=>'Comienzo Primer Semestre.',
    'state.7.title'=>'Actas Primer Semestre Abiertas.',
    'state.8.title'=>'Comienzo Segundo Semestre. Actas Primer Semestre Cerradas.',
    'state.9.title'=>'Actas Segundo Semestre Abiertas.',
    'state.10.title'=>'Curso Cerrado.',

    'state.0.body'=>'-Los <strong>futuros estudiantes</strong> pueden aplicar para las diferentes escuelas.',
    'state.1.body'=>'-Primeras adjudicaciones computadas.<br>-Los <strong>futuros estudiantes</strong> ya no pueden inscribirse.<br>-Los <strong>futures estudiantes</strong> pueden ahora aceptar o rechazar sus ofertas.',
    'state.2.body'=>'-Segunda y final lista de adjudicaciones computada.<br>-Los <strong>futuros estudiantes</strong> pueden aceptar las adjudicaciones finales.',
    'state.3.body'=>'-Las instancias de las asignaturas son autogeneradas.<br>-Los nuevos estudiantes son autogenerados en base a las inscripciones aceptadas.<br>-Los <strong>estudiantes</strong> pueden matricularse ahora.<br>-Los <strong>PDIs de administración</strong> no pueden modificar las asignaturas, los grados ni los departamentos ya.',
    'state.4.body'=>'-Los grupos son autogenerados basados en las matrículas y el máximo número de estudiantes por grupo.<br>-Los <strong>estudiantes</strong> ya no pueden matricularse.<br>-Los <strong>PDIs de administración</strong> pueden asignar el horario y las aulas a los grupos.<br>-Los <strong>coordinadores</strong> pueden asignar profesores a los grupos.',
    'state.5.body'=>'-Los <strong>estudiantes</strong> pueden cambiar de grupo ahora.<br>Los grupos no pueden ser modificados ya.',
    'state.6.body'=>'-Los <strong>estudiantes</strong> ya no pueden permutar grupos más.<br>-El curso comienza ahora.',
    'state.7.body'=>'-Las actas de las asignaturas del primer semestre se autogeneran de los exámenes realizados.<br>-Los <strong>PDIs de Administración</strong> pueden modificar las actas del primer semestre ahora.',
    'state.8.body'=>'-Los <strong>PDIs de Administración</strong> no  pueden modificar las actas.<br>-El segundo semestre comienza ahora.',
    'state.9.body'=>'-Las actas de las asignaturas del segundo semestre y anuales se autogeneran de los exámenes realizados.<br>-Los <strong>PDIs de Administración</strong> pueden modificar las actas del segundo semestre y de asignaturas anuales ahora.',
    'state.10.body'=>'-Los <strong>PDIs de Administración</strong> no  pueden modificar las actas.<br>-Los <strong>PDIs de administración</strong> pueden modificar las asignaturas, los departamentos y los grados ahora.',
];