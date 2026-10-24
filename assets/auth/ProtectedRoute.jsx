import { Navigate, Outlet } from 'react-router-dom'
import { useAuth } from './AuthContext'

export default function ProtectedRoute() {
  const { usuario, cargando } = useAuth()
  if (cargando) return <p className="p-8">Cargando...</p>
  return usuario ? <Outlet /> : <Navigate to="/login" replace />
}
