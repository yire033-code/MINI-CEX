<?php

namespace App\Controllers;

class ReportController extends BaseController
{
    public function generate()
    {
        // Dynamically increase PHP memory limit to handle high-resolution image processing safely
        @ini_set('memory_limit', '512M');

        // Create TCPDF instance
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Configure metadata
        $pdf->SetCreator('Yire');
        $pdf->SetAuthor('Desarrollador MINI-CEX');
        $pdf->SetTitle('Reporte Tecnico e Informe de Tiempos - Ecosistema MINI-CEX');
        $pdf->SetSubject('Reporte de Proyecto MINI-CEX');
        $pdf->SetKeywords('MINI-CEX, PHP, Android, Kotlin, SQLite, PDF, Reporte, Tiempos');

        // Page setup
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 20, 20);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(15);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 10);

        // --- PAGE 1: COVER ---
        $pdf->AddPage();

        $primaryColor = '#1B5E96'; // Azul Institucional
        $accentColor = '#B8860B';  // Oro Corporativo
        $darkColor = '#1E293B';    // Gris Pizarra Oscuro
        $lightGray = '#F8FAFC';    // Gris Tiza
        $border = '#E2E8F0';       // Gris Borde

        $htmlPortada = '
        <div style="text-align: center; font-family: helvetica;">
            <br><br>
            <span style="font-size: 13pt; color: ' . $accentColor . '; font-weight: bold; letter-spacing: 1px;">TERAPIA FÍSICA Y REHABILITACIÓN</span>
            <br><br>
            <div style="border-top: 3px solid ' . $primaryColor . '; border-bottom: 3px solid ' . $accentColor . '; padding: 25px 0; margin: 20px 0;">
                <br><br>
                <span style="font-size: 26pt; color: ' . $primaryColor . '; font-weight: bold; line-height: 1.3;">REPORTE TÉCNICO Y ESTIMACIÓN DE TIEMPOS DE DESARROLLO</span>
                <br><br>
                <span style="font-size: 16pt; color: ' . $darkColor . '; font-weight: 500; font-style: italic;">Ecosistema Integrado MINI-CEX (Android & Web App)</span>
                <br><br>
            </div>
            
            <br><br><br><br>
            
            <table cellpadding="6" style="width: 100%; font-size: 11pt; border-collapse: collapse; margin-top: 50px;">
                <tr>
                    <td style="width: 30%; text-align: right; color: ' . $accentColor . '; font-weight: bold;">PROYECTO:</td>
                    <td style="width: 70%; text-align: left; color: ' . $darkColor . ';">Plataforma Autónoma de Rúbricas MINI-CEX</td>
                </tr>
                <tr>
                    <td style="text-align: right; color: ' . $accentColor . '; font-weight: bold;">AUTOR (DEVELOPER):</td>
                    <td style="text-align: left; color: ' . $darkColor . '; font-weight: bold;">Yire Abdiel Ramírez Sánchez</td>
                </tr>
                <tr>
                    <td style="text-align: right; color: ' . $accentColor . '; font-weight: bold;">ARQUITECTURA:</td>
                    <td style="text-align: left; color: ' . $darkColor . ';">Offline-First, Room SQLite (App) y XAMPP Backend (PHP/MySQL)</td>
                </tr>
                <tr>
                    <td style="text-align: right; color: ' . $accentColor . '; font-weight: bold;">FECHA DE ENTREGA:</td>
                    <td style="text-align: left; color: ' . $darkColor . ';">Mayo 2026</td>
                </tr>
            </table>
            
            <br><br><br><br><br><br>
            <div style="text-align: center; color: ' . $primaryColor . '; font-size: 10pt; font-weight: bold;">
                SISTEMA DE GESTIÓN INSTITUCIONAL MINI-CEX
            </div>
        </div>
        ';

        $pdf->writeHTML($htmlPortada, true, false, true, false, '');

        // --- PAGE 2: INTRO AND LOGS ---
        $pdf->AddPage();

        $htmlIntro = '
        <div style="font-family: helvetica; color: ' . $darkColor . '; line-height: 1.6;">
            <h2 style="font-size: 18pt; color: ' . $primaryColor . '; border-bottom: 1.5px solid ' . $accentColor . '; padding-bottom: 8px;">1. Introducción al Proyecto</h2>
            <p style="font-size: 10.5pt; text-align: justify;">
                Como el desarrollador principal y arquitecto de software de este ecosistema, he diseñado e implementado una solución de alta fidelidad para la <b>Facultad de Terapia Física y Rehabilitación</b>. Mi objetivo principal fue construir una plataforma autónoma e inteligente que permitiera a los docentes evaluar las competencias clínicas de sus estudiantes en tiempo real a través del estándar clínico <b>MINI-CEX (Mini Clinical Evaluation Exercise)</b>.
            </p>
            <p style="font-size: 10.5pt; text-align: justify;">
                Este desarrollo exigió una arquitectura full-stack interconectada que equivale a <b>1 mes íntegro de trabajo profesional a tiempo completo (160 horas)</b>. Se integra en dos frentes tecnológicos: una aplicación móvil Android nativa operando Offline-First, y un portal web administrativo robusto hospedado localmente bajo XAMPP que centraliza las bases de datos y orquesta la sincronización asíncrona bidireccional.
            </p>
            
            <h2 style="font-size: 18pt; color: ' . $primaryColor . '; border-bottom: 1.5px solid ' . $accentColor . '; padding-bottom: 8px; margin-top: 30px;">2. Logros Técnicos Implementados</h2>
            <p style="font-size: 10.5pt; text-align: justify;">
                A lo largo del proyecto, yo lideré, diseñé e implementé los siguientes componentes de ingeniería de software:
            </p>
            <ul style="font-size: 10pt; text-align: justify;">
                <li><b>Resiliencia Offline y Autocuración de Datos:</b> Creé un motor en la app móvil (Room/SQLite) que procesa evaluaciones sin conexión. Desarrollé un algoritmo de autocuración de llaves foráneas (Foreign Keys) que adapta dinámicamente los IDs de maestros y alumnos basándose en UUIDs, emails y matrículas, previniendo caídas totales de integridad durante la reconexión.</li>
                <li><b>Asistente Móvil de Evaluación Inteligente (Wizard):</b> Diseñé un flujo visual premium con ViewPager2 de 4 pasos (Datos Generales, Rúbrica, Feedback y Conformidad). Implementé cronometraje automatizado de sesiones (Observación/Feedback) y lienzos de dibujo digital interactivo (Canvas) para la recolección de firmas ológrafas nativas.</li>
                <li><b>Sincronización Bidireccional Asíncrona (Colas):</b> Codifiqué un sistema transaccional donde las operaciones de crear, modificar o eliminar registros se encolan independientemente en el servidor web y la aplicación. Los cambios se unifican sin conflictos empleando corutinas de fondo en Android.</li>
                <li><b>Generación de Reportes PDF y Correos SMTP:</b> Desarrollé los motores de dibujo vectorial para PDF (backend con TCPDF y Android con bibliotecas nativas). Integré correos automáticos en PHP con Multipart MIME para enviar directamente los resultados en PDF a los estudiantes evaluados.</li>
                <li><b>Carga Masiva Web Avanzada (Excel):</b> Diseñé un portal administrativo web (PHP PDO) con tecnología interactiva (SheetJS) que permite arrastrar y cargar lotes de estudiantes desde Excel. El sistema previene duplicados, genera UUIDs universales y maneja borrados en cascada para mantener la base de datos MySQL impecable.</li>
            </ul>
        </div>
        ';

        $pdf->writeHTML($htmlIntro, true, false, true, false, '');

        // --- PAGE 3: HOURS TABLE ---
        $pdf->AddPage();

        $htmlTimeline = '
        <div style="font-family: helvetica; color: ' . $darkColor . ';">
            <h2 style="font-size: 18pt; color: ' . $primaryColor . '; border-bottom: 1.5px solid ' . $accentColor . '; padding-bottom: 8px;">3. Informe Detallado de Tiempos (Horas de Desarrollo)</h2>
            <p style="font-size: 10.5pt; text-align: justify;">
                A continuación, desgloso de manera minuciosa la inversión de tiempo equivalente a <b>160 horas (1 mes de trabajo estándar)</b>. Estas métricas reflejan las labores de arquitectura, codificación, pruebas y validación requeridas para un sistema integrado en múltiples plataformas:
            </p>
            
            <table cellpadding="8"
               style="width:100%;
                      border:1px solid ' . $border . ';
                      font-size:9.5pt;
                      table-layout:fixed;
                      border-collapse:collapse;">
        
                <tr style="background-color:' . $primaryColor . '; color:white; font-weight:bold;">
                    <th style="width:25%; border:1px solid ' . $border . ';">Componente / Fase</th>
                    <th style="width:15%; text-align:center; border:1px solid ' . $border . ';">Horas</th>
                    <th style="width:60%; border:1px solid ' . $border . ';">Descripción de Tareas Clave</th>
                </tr>
        
                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 1: Arquitectura y Diseño de BD (Web/Local)
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        16 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Modelado de esquemas MySQL relacionales y SQLite (Room), creación de índices únicos, reglas de cascada y planeación de sincronía bidireccional basada en UUIDs universales.
                    </td>
                </tr>
        
                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 2: Backend XAMPP y Panel Admin Web
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        28 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Programación de controladores seguros en PHP PDO, manejo de sesiones, importador masivo interactivo para Excel (SheetJS) y manejo inteligente de borrado y dependencias (Constraints).
                    </td>
                </tr>
        
                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 3: Core Móvil (Room, MVVM y Flujos)
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        24 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Programación de Repositorios en Kotlin, estructura MVVM (Model-View-ViewModel), DAOs para bases de datos complejas locales y autenticación offline con persistencia cifrada.
                    </td>
                </tr>
        
                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 4: Asistente UI, Tiempos y Firmas App
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        32 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Diseño Premium del Wizard de 4 pasos (ViewPager2), validación en tiempo real, cronómetros interactivos, captura digital de firmas (Canvas) e inyección de datos a la BD.
                    </td>
                </tr>

                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 5: Motor de Sincronización Transaccional
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        30 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Algoritmos asíncronos para encolado de red, autocuración de IDs por correo o matrícula, detección automática de perfiles eliminados y reconstrucción dinámica de bases de datos.
                    </td>
                </tr>
        
                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 6: Motores de PDF y Envíos SMTP
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        18 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Motor de reportes PDF a medida en PHP (TCPDF), diseño gráfico estructurado de los tickets de evaluación, y protocolo SMTP para notificación automática y envíos directos a los alumnos.
                    </td>
                </tr>

                <tr>
                    <td style="width:25%; font-weight:bold; background-color:' . $lightGray . '; border:1px solid ' . $border . ';">
                        Fase 7: Pruebas, Debugging y Optimización
                    </td>
                    <td style="width:15%; text-align:center; font-weight:bold; border:1px solid ' . $border . ';">
                        12 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
                        Resolución de excepciones NullPointer, ajustes contra fugas de memoria, refinamiento de interfaces y compilación de APK optimizada para producción real en entornos clínicos.
                    </td>
                </tr>
        
                <tr style="background-color:' . $primaryColor . '; color:white; font-weight:bold; font-size:11pt;">
                    <td style="width:25%; text-align:right; border:1px solid ' . $border . ';">
                        TOTAL ESTIMADO
                    </td>
                    <td style="width:15%; text-align:center; border:1px solid ' . $border . ';">
                        160 hrs
                    </td>
                    <td style="width:60%; border:1px solid ' . $border . ';">
        
                        Aproximadamente 4 semanas (1 mes) de dedicación profesional completa (Full-Time).
                    </td>
                </tr>
        
            </table>
            
            <br><br>
            <h2 style="font-size: 18pt; color: ' . $primaryColor . '; border-bottom: 1.5px solid ' . $accentColor . '; padding-bottom: 8px; margin-top: 25px;">4. Conclusiones de Mi Entrega</h2>
            <p style="font-size: 10.5pt; text-align: justify;">
                He invertido un total de <b>160 horas de ingeniería de software estructuradas</b> para garantizar que esta plataforma no sea un simple producto viable, sino un ecosistema robusto, premium, y de nivel institucional. El éxito absoluto de la compilación local de Android (0 errores, 0 advertencias) y la exitosa comunicación cliente-servidor demuestran la solidez de los entregables y la calidad de la arquitectura implementada.
            </p>
            
            <br><br><br>
            <table cellpadding="0" style="width: 100%; border-collapse: collapse; font-size: 10.5pt;">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <br><br>
                        ________________________________________<br>
                        <b>Desarrollador de Software</b><br>
                        Líder Técnico Ecosistema MINI-CEX
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <br><br>
                        ________________________________________<br>
                        <b>Facultad de Terapia Física y Rehabilitación</b><br>
                        Representante de Acreditación Académica
                    </td>
                </tr>
            </table>
        </div>
        ';

        try {
            $pdf->writeHTML($htmlTimeline, true, false, true, false, '');
            $pdfContent = $pdf->Output('reporte_tiempos_minicex.pdf', 'S');

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="reporte_tiempos_minicex.pdf"')
                ->setBody($pdfContent);
        } catch (\Throwable $e) {
            return $this->response->setBody('Error PDF: ' . $e->getMessage() . ' en la línea ' . $e->getLine());
        }
    }
}
