import "./app.css";
import { createRoot } from "react-dom/client";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { AuthProvider, useAuth } from "./auth/AuthContext";
import ProtectedRoute from "./auth/ProtectedRoute";
import RootLayout from "./layouts/RootLayout";
import AppLayout from "./layouts/AppLayout";
import LoginPage from "./pages/login/LoginPage";
import Pendiente from "./pages/Pendiente";
import RequiereModulo from "./auth/RequiereModulo";
import PerfilPage from "./pages/perfil/PerfilPage";

const PAGINAS = [
    {
        modulo: "PERFIL",
        ruta: "/perfil",
        titulo: "Perfil",
        componente: PerfilPage,
    },
    { modulo: "SOLICITANTES", ruta: "/solicitantes", titulo: "Solicitantes" },
    { modulo: "CONSULTAS", ruta: "/consultas", titulo: "Consultas" },
    { modulo: "ENTREVISTAS", ruta: "/entrevistas", titulo: "Entrevistas" },
    { modulo: "CASOS", ruta: "/casos", titulo: "Casos" },
    { modulo: "AUDIENCIAS", ruta: "/audiencias", titulo: "Audiencias" },
    { modulo: "PERSONAL", ruta: "/personal", titulo: "Personal" },
    { modulo: "ESTADISTICAS", ruta: "/estadisticas", titulo: "Estadísticas" },
    { modulo: "ESTUDIANTES", ruta: "/estudiantes", titulo: "Estudiantes" },
    { modulo: "PROFESORES", ruta: "/profesores", titulo: "Profesores" },
];

function Inicio() {
    const { menu } = useAuth();
    return <Navigate to={menu[0]?.ruta ?? "/perfil"} replace />;
}

createRoot(document.getElementById("root")).render(
    <BrowserRouter>
        <AuthProvider>
            <Routes>
                <Route path="/login" element={<LoginPage />} />
                <Route element={<RootLayout />}>
                    <Route element={<ProtectedRoute />}>
                        <Route element={<AppLayout />}>
                            <Route path="/" element={<Inicio />} />
                            {PAGINAS.map((p) => (
                                <Route
                                    key={p.ruta}
                                    path={p.ruta}
                                    element={
                                        <RequiereModulo modulo={p.modulo}>
                                            {p.componente ? (
                                                <p.componente />
                                            ) : (
                                                <Pendiente titulo={p.titulo} />
                                            )}
                                        </RequiereModulo>
                                    }
                                />
                            ))}
                        </Route>
                    </Route>
                </Route>
            </Routes>
        </AuthProvider>
    </BrowserRouter>,
);
