import { Navigate } from 'react-router-dom'
import { useAuth } from './AuthContext'

export default function RequiereModulo({ modulo, children }) {
  const { puede } = useAuth()
  return puede(modulo, 'ver') ? children : <Navigate to="/" replace />
}
