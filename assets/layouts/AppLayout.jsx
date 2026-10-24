import { useState } from 'react'
import { NavLink, Outlet, useNavigate } from 'react-router-dom'
import { useAuth } from '../auth/AuthContext'

// Trazos SVG de los iconos. Las claves coinciden con MODU_ICONCARACTER de TVM_MODULO.
const ICONOS = {
  user: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
  chart: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
  plus: 'M12 4v16m8-8H4',
  users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
  search: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
  mic: 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z',
  folder: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
  calendar: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
  handshake: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
  salir: 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
  menu: 'M4 6h16M4 12h16M4 18h16',
  cerrar: 'M6 18L18 6M6 6l12 12',
}

function Icono({ nombre }) {
  const trazos = [].concat(ICONOS[nombre] ?? ICONOS.folder)
  return (
    <svg className="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      {trazos.map((d, i) => (
        <path key={i} strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={d} />
      ))}
    </svg>
  )
}

export default function AppLayout() {
  const { menu, logout } = useAuth()
  const navigate = useNavigate()
  const [abierto, setAbierto] = useState(false)   // solo afecta a móviles

  async function salir() {
    await logout()
    navigate('/login')
  }

  return (
    <div className="flex flex-row-reverse flex-1">
      {/* Fondo oscuro al abrir el menú en móvil */}
      {abierto && (
        <div className="fixed inset-0 bg-black/50 z-40 md:hidden" onClick={() => setAbierto(false)} />
      )}

      {/* Botón para abrir el menú en móvil */}
      <button
        onClick={() => setAbierto(true)}
        className="md:hidden fixed bottom-4 right-4 z-30 p-3 rounded-full text-white shadow-lg cursor-pointer"
        style={{ backgroundColor: '#e2001a' }}
        aria-label="Abrir menú"
      >
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={ICONOS.menu} />
        </svg>
      </button>

      {/* Mismo ancho (w-64) que la imagen de la derecha del header */}
      <aside
            className={`fixed top-0 bottom-0 right-0 md:top-[72px] z-50 w-64 bg-white shadow-lg overflow-y-auto flex flex-col
            transform transition-transform duration-300 ease-in-out
            ${abierto ? 'translate-x-0' : 'translate-x-full'}
            md:translate-x-0`}
    >
        <div className="p-4 flex flex-col flex-1">
          {/* Título centrado; el botón de cerrar solo aparece en móvil */}
          <div className="relative mb-6">
            <h2 className="text-xl font-bold text-gray-800 text-center">MENÚ</h2>
            <button
              onClick={() => setAbierto(false)}
              className="md:hidden absolute right-0 top-0 text-gray-600 hover:text-gray-800 cursor-pointer"
              aria-label="Cerrar menú"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={ICONOS.cerrar} />
              </svg>
            </button>
          </div>

          <nav className="space-y-2">
            {menu.map(m => (
              <NavLink
                key={m.id}
                to={m.ruta}
                end
                onClick={() => setAbierto(false)}
                className={({ isActive }) =>
                  'flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors ' +
                  (isActive
                    ? 'bg-red-100 text-red-700 font-semibold'
                    : 'text-gray-700 hover:bg-gray-100')
                }
              >
                <Icono nombre={m.icono} />
                <span>{m.nombre}</span>
              </NavLink>
            ))}
          </nav>

          {/* mt-auto lo empuja al fondo del menú */}
          <button
            onClick={salir}
            className="mt-auto w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors border-t border-gray-200 cursor-pointer"
          >
            <Icono nombre="salir" />
            <span>Cerrar Sesión</span>
          </button>
        </div>
      </aside>

      <main className="flex-1 p-6 bg-[#f7f7f7]">
        <Outlet />
      </main>
    </div>
  )
}
