<?php


return[
    'edit.tab1'=>'System parameters edition',
    'edit.tab2'=>'System actions',
    'edit.dashboard'=>'DashBoard',
    'success'=>'System parameters successfully modified.',
    'error'=>'There was an error when modifying system parameters.',
    'increment.success'=>'State machine was incremented successfully.',
    'increment.error'=>'There was an error changing the state.',
    'state.actual'=>'Actual State',
    'state.next'=>'Next State',
    'state.go'=>'Go',


    'state.0.title'=>'Inscriptions opened.',
    'state.1.title'=>'First Inscriptions Computed.',
    'state.2.title'=>'Final inscriptions Computed.',
    'state.3.title'=>'Opened enrollments.',
    'state.4.title'=>'Enrollments Closed. Groups assignations.',
    'state.5.title'=>'First Semester Starts.',
    'state.6.title'=>'Opened First Semester Minutes.',
    'state.7.title'=>'Second Semester Starts. First Semester Minutes Closed.',
    'state.8.title'=>'Opened Second Semester Minutes.',
    'state.9.title'=>'Course closed.',

    'state.0.body'=>'-<strong>Future Students</strong> can apply now for different Schools.',
    'state.1.body'=>'-First inscriptions list computed.<br>-<strong>Future Students</strong> can no longer apply.<br>-<strong>Future Students</strong> can now accept or decline their offers.',
    'state.2.body'=>'-Second and final inscriptions list computed.<br>-<strong>Future Students</strong> can accept now their final offers.',
    'state.3.body'=>'-Subject Instances are autogenerated.<br>-<strong>New Students</strong> are autogenerated based on accepted inscriptions.<br>-<strong>Students</strong> can enroll Subjects now.<br>-<strong>Management PDIs</strong> cannot modify Subjects, Degrees or Departments anymore.',
    'state.4.body'=>'-Groups are generated based on enrollments and the maximum number of students per group.<br>-<strong>Students</strong> can no longer enroll asignments.<br>-<strong>Management PDIs</strong> can set teachers and rooms to groups now.<br>-<strong>Students</strong> can exchange groups now.',
    'state.5.body'=>'-<br>-<strong>Students</strong> can no exchange groups.<br>-Groups cannot be modified now.',
    'state.6.body'=>'-Minutes are autogenerated from Control Checks of Subjects from the first semester.<br>-<strong>Management PDIs</strong> can modify Minutes of subjects from the first semester now.<br>-<strong>Students</strong> cannot exchange groups anymore.<br>-<strong>Management PDIs</strong> cannot set teachers and rooms to groups anymore.',
    'state.7.body'=>'-<strong>Management PDIs</strong> cannot change Minutes anymore.',
    'state.8.body'=>'-Minutes are autogenerated from Control Checks of Subjects from the second semester and annuals.<br>-<strong>Management PDIs</strong> can modify Minutes of subjects from the second semester and annuals now.\'',
    'state.9.body'=>'-<strong>Management PDIs</strong> cannot change Minutes anymore.<br>-<strong>Management PDIs</strong> can modify subjects, departments and degrees now.',

];