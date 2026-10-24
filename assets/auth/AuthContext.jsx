import { createContext, useContext, useEffect, useState } from 'react'
import { api } from '../api/client'

const AuthContext = createContext(null)
export const useAuth = () => useContext(AuthContext)

export function AuthProvider({ children }) {
  const [usuario, setUsuario] = useState(null)
  const [menu, setMenu] = useState([])
  const [cargando, setCargando] = useState(true)

  useEffect(() => {
    api('/api/auth/me')
      .then(d => { setUsuario(d.usuario); setMenu(d.menu) })
      .catch(() => {})
      .finally(() => setCargando(false))
  }, [])

  async function login(documento, password) {
    const d = await api('/api/auth/login', { method: 'POST', body: { documento, password } })
    setUsuario(d.usuario)
    setMenu(d.menu)
  }

  async function logout() {
    await api('/api/auth/logout', { method: 'POST' })
    setUsuario(null)
    setMenu([])
  }

  const puede = (modulo, accion = 'ver') =>
  menu.find(m => m.id === modulo)?.puede?.[accion] ?? false

  return (
   <AuthContext.Provider value={{ usuario, menu, cargando, login, logout, puede }}>
      {children}
    </AuthContext.Provider>
  )
}
