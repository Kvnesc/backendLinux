<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class LinuxCourseSeeder extends Seeder
{
    public function run(): void
    {
        if (Course::exists()) {
            return;
        }

        $courses = [
            [
                'slug' => 'linux-desde-cero',
                'title' => 'Linux desde cero',
                'summary' => 'Terminal, sistema de archivos y herramientas esenciales para trabajar con confianza.',
                'level' => 'principiante',
                'modules' => [
                    ['title' => 'La terminal y navegación', 'lessons' => [
                        ['title' => 'Tu primera terminal', 'content' => "Linux se administra principalmente mediante comandos. Aprende la diferencia entre usuario, shell, terminal y prompt.\n\nObjetivos:\n- identificar el directorio actual;\n- listar archivos;\n- cambiar de directorio;\n- entender rutas absolutas y relativas.", 'command' => "$ pwd\n/home/usuario\n$ ls -la\n$ cd /etc", 'prompt' => '¿Qué comando muestra el directorio actual?', 'answer' => 'pwd', 'hint' => 'Son tres letras y significa print working directory.', 'explanation' => 'pwd imprime la ruta absoluta del directorio de trabajo actual.'],
                        ['title' => 'Ayuda y manuales', 'content' => "No memorices todo. En Linux es profesional saber encontrar ayuda. Usa man para manuales y --help para una referencia rápida.\n\nPrueba también apropos para buscar comandos por descripción.", 'command' => "$ man ls\n$ ls --help\n$ apropos network", 'prompt' => 'Escribe el comando para abrir el manual de chmod.', 'answer' => 'man chmod', 'hint' => 'Usa man seguido del nombre del comando.', 'explanation' => 'man chmod abre la página de manual de chmod.'],
                    ]],
                    ['title' => 'Archivos y búsqueda', 'lessons' => [
                        ['title' => 'Crear, copiar, mover y borrar', 'content' => "Domina mkdir, touch, cp, mv y rm. Antes de usar rm -r verifica la ruta; Linux normalmente no usa una papelera para comandos de terminal.", 'command' => "$ mkdir practica\n$ touch practica/nota.txt\n$ cp practica/nota.txt practica/copia.txt\n$ mv practica/copia.txt practica/final.txt", 'prompt' => 'Crea un directorio llamado laboratorio.', 'answer' => 'mkdir laboratorio', 'hint' => 'El comando significa make directory.', 'explanation' => 'mkdir crea uno o más directorios.'],
                        ['title' => 'Buscar con find y grep', 'content' => "find busca entradas del sistema de archivos; grep busca patrones dentro de texto. Juntos resuelven gran parte de las tareas de diagnóstico y administración.", 'command' => "$ find /var/log -name '*.log'\n$ grep -R \"error\" /var/log 2>/dev/null", 'prompt' => 'Busca recursivamente la palabra error dentro del directorio logs.', 'answer' => 'grep -R error logs', 'hint' => 'Usa grep con -R.', 'explanation' => 'grep -R recorre subdirectorios y busca el patrón indicado.'],
                    ]],
                ],
            ],
            [
                'slug' => 'administracion-linux',
                'title' => 'Administración Linux',
                'summary' => 'Usuarios, permisos, procesos, paquetes, servicios y registros del sistema.',
                'level' => 'intermedio',
                'modules' => [
                    ['title' => 'Identidad y permisos', 'lessons' => [
                        ['title' => 'Usuarios y grupos', 'content' => "Un sistema multiusuario separa identidades y permisos. Aprende id, whoami, useradd/usermod y grupos. En distribuciones diferentes la creación de usuarios puede tener herramientas auxiliares distintas.", 'command' => "$ whoami\n$ id\n$ groups", 'prompt' => '¿Qué comando muestra UID, GID y grupos del usuario actual?', 'answer' => 'id', 'hint' => 'Tiene dos letras.', 'explanation' => 'id muestra UID, GID y grupos asociados.'],
                        ['title' => 'chmod, chown y umask', 'content' => "Los permisos tradicionales usan lectura (r), escritura (w) y ejecución (x) para propietario, grupo y otros. Aprende notación simbólica y octal antes de usar permisos amplios como 777.", 'command' => "$ chmod 640 informe.txt\n$ chmod u+x script.sh\n$ chown usuario:grupo archivo", 'prompt' => 'Da permiso de ejecución al propietario de script.sh usando notación simbólica.', 'answer' => 'chmod u+x script.sh', 'hint' => 'u representa user y +x agrega ejecución.', 'explanation' => 'chmod u+x modifica solo el bit de ejecución del propietario.'],
                    ]],
                    ['title' => 'Procesos, paquetes y servicios', 'lessons' => [
                        ['title' => 'Procesos y señales', 'content' => "ps muestra procesos; top ofrece una vista dinámica; kill envía señales. SIGTERM permite terminar ordenadamente y suele preferirse antes de SIGKILL.", 'command' => "$ ps aux\n$ top\n$ kill 1234\n$ kill -9 1234", 'prompt' => 'Envía la señal TERM al proceso con PID 1234 usando la forma simple.', 'answer' => 'kill 1234', 'hint' => 'kill sin especificar señal envía TERM normalmente.', 'explanation' => 'kill PID envía SIGTERM por defecto en sistemas POSIX comunes.'],
                        ['title' => 'systemd y journalctl', 'content' => "En muchas distribuciones modernas systemd administra servicios. systemctl controla unidades y journalctl consulta el journal. No todas las distribuciones usan systemd, por eso conviene entender el concepto de init y servicio.", 'command' => "$ systemctl status ssh\n$ systemctl restart nginx\n$ journalctl -u nginx --since today", 'prompt' => 'Muestra el estado del servicio nginx.', 'answer' => 'systemctl status nginx', 'hint' => 'systemctl + status + nombre.', 'explanation' => 'systemctl status muestra estado, PID y eventos recientes de una unidad.'],
                    ]],
                ],
            ],
            [
                'slug' => 'bash-scripting',
                'title' => 'Bash scripting',
                'summary' => 'Automatiza tareas con variables, condiciones, bucles, funciones, pipes y control de errores.',
                'level' => 'avanzado',
                'modules' => [
                    ['title' => 'Fundamentos de Bash', 'lessons' => [
                        ['title' => 'Variables, quoting y exit status', 'content' => "En Bash no pongas espacios alrededor de = al asignar. Usa comillas dobles cuando quieras expansión de variables y comillas simples para texto literal. El código de salida 0 indica éxito por convención.", 'command' => "$ nombre='Linux'\n$ echo \"Hola \$nombre\"\n$ echo $?", 'prompt' => 'Asigna el valor Linux a una variable llamada sistema.', 'answer' => 'sistema=Linux', 'hint' => 'No uses espacios alrededor de =.', 'explanation' => 'Las asignaciones Bash usan nombre=valor sin espacios.'],
                        ['title' => 'Condiciones y bucles', 'content' => "if, case, for y while permiten expresar lógica. Cita variables en tests cuando puedan contener espacios y prefiere [[ ... ]] en Bash para condiciones complejas.", 'command' => "$ if [[ -f /etc/passwd ]]; then echo ok; fi\n$ for f in *.log; do echo \"\$f\"; done", 'prompt' => 'Escribe una prueba Bash que verifique si /etc/passwd es un archivo regular.', 'answer' => '[[ -f /etc/passwd ]]', 'hint' => 'Usa -f dentro de [[ ]].', 'explanation' => '-f comprueba que la ruta existe y es un archivo regular.'],
                    ]],
                    ['title' => 'Scripts robustos', 'lessons' => [
                        ['title' => 'Funciones, pipes y redirecciones', 'content' => "Las funciones agrupan lógica reutilizable. Los pipes conectan stdout de un proceso con stdin del siguiente. Las redirecciones controlan stdin, stdout y stderr.", 'command' => "$ cat access.log | grep 500 | wc -l\n$ comando >salida.txt 2>error.txt", 'prompt' => 'Redirige stdout de ls a archivos.txt.', 'answer' => 'ls > archivos.txt', 'hint' => 'Usa > para stdout.', 'explanation' => '> crea o reemplaza el archivo con la salida estándar.'],
                        ['title' => 'set -euo pipefail y traps', 'content' => "Para scripts administrativos, combina validación explícita con opciones estrictas. set -euo pipefail ayuda a detectar fallos, pero no sustituye el manejo consciente de errores. trap permite limpiar archivos temporales o reaccionar a señales.", 'command' => "$ set -euo pipefail\n$ trap 'rm -f /tmp/app.lock' EXIT", 'prompt' => 'Escribe la línea que activa errexit, nounset y pipefail.', 'answer' => 'set -euo pipefail', 'hint' => 'Es una línea habitual al comienzo de scripts Bash.', 'explanation' => 'La combinación activa -e, -u y pipefail para detectar múltiples clases de error.'],
                    ]],
                ],
            ],
            [
                'slug' => 'linux-profesional',
                'title' => 'Linux profesional',
                'summary' => 'Redes, SSH, almacenamiento, seguridad, diagnóstico y automatización operativa.',
                'level' => 'profesional',
                'modules' => [
                    ['title' => 'Redes y almacenamiento', 'lessons' => [
                        ['title' => 'Diagnóstico de red y SSH', 'content' => "Aprende ip, ss, ping, dig/curl y ssh. Distingue resolución DNS, conectividad IP, puerto TCP y aplicación: diagnosticar por capas evita perder tiempo.", 'command' => "$ ip addr\n$ ip route\n$ ss -tulpn\n$ ssh usuario@servidor", 'prompt' => 'Muestra sockets TCP/UDP en escucha con procesos usando ss.', 'answer' => 'ss -tulpn', 'hint' => 'Combina -t -u -l -p -n.', 'explanation' => 'ss -tulpn muestra TCP, UDP, listening, procesos y valores numéricos.'],
                        ['title' => 'Discos, filesystems y mount', 'content' => "lsblk muestra dispositivos de bloques; df muestra uso de filesystems montados; du estima uso por archivos/directorios. mount y /etc/fstab controlan montajes persistentes.", 'command' => "$ lsblk -f\n$ df -h\n$ du -sh /var/log", 'prompt' => 'Muestra uso de sistemas de archivos en formato legible.', 'answer' => 'df -h', 'hint' => 'df con la opción human-readable.', 'explanation' => 'df -h muestra capacidad, uso y espacio libre con unidades legibles.'],
                    ]],
                    ['title' => 'Operación profesional', 'lessons' => [
                        ['title' => 'Logs y troubleshooting sistemático', 'content' => "Un diagnóstico profesional empieza por reproducir, acotar el alcance, revisar métricas/logs, formular una hipótesis y probarla con el cambio mínimo. Evita modificar varias cosas a la vez.", 'command' => "$ journalctl -p err -b\n$ dmesg --level=err,warn\n$ tail -f /var/log/syslog", 'prompt' => 'Muestra errores del journal del arranque actual.', 'answer' => 'journalctl -p err -b', 'hint' => '-p filtra prioridad y -b el boot actual.', 'explanation' => 'journalctl -p err -b limita la consulta a prioridad error del arranque actual.'],
                        ['title' => 'Seguridad y automatización operativa', 'content' => "Aplica mínimo privilegio, actualizaciones, autenticación por claves, firewall y revisión periódica. Automatiza tareas repetibles con scripts y systemd timers/cron, dejando logs y resultados verificables.", 'command' => "$ ssh-keygen -t ed25519\n$ sudo -l\n$ systemctl list-timers", 'prompt' => 'Genera una clave SSH moderna de tipo Ed25519.', 'answer' => 'ssh-keygen -t ed25519', 'hint' => 'ssh-keygen con -t.', 'explanation' => 'Ed25519 es una opción moderna y compacta para claves SSH cuando está soportada.'],
                    ]],
                ],
            ],
        ];

        foreach ($courses as $coursePosition => $courseData) {
            $course = Course::create([
                'slug' => $courseData['slug'],
                'title' => $courseData['title'],
                'summary' => $courseData['summary'],
                'level' => $courseData['level'],
                'position' => $coursePosition + 1,
            ]);

            foreach ($courseData['modules'] as $modulePosition => $moduleData) {
                $module = $course->modules()->create([
                    'title' => $moduleData['title'],
                    'position' => $modulePosition + 1,
                ]);

                foreach ($moduleData['lessons'] as $lessonPosition => $lessonData) {
                    $lesson = $module->lessons()->create([
                        'title' => $lessonData['title'],
                        'content' => $lessonData['content'],
                        'command_example' => $lessonData['command'],
                        'estimated_minutes' => 12,
                        'position' => $lessonPosition + 1,
                    ]);

                    $lesson->exercises()->create([
                        'type' => 'command',
                        'prompt' => $lessonData['prompt'],
                        'expected_answer' => $lessonData['answer'],
                        'case_sensitive' => false,
                        'hint' => $lessonData['hint'],
                        'explanation' => $lessonData['explanation'],
                        'position' => 1,
                    ]);
                }
            }
        }
    }
}
