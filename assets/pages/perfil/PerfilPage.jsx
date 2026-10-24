import { useEffect, useState } from 'react'
import { api } from '../../api/client'
import { useAuth } from '../../auth/AuthContext'
import logoUfpso from '../../images/logoufpso.png'

const ROJO = '#b3122a'   // rojo del título, como en tu diseño anterior

const ICONOS = {
  user: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
  documento: 'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2',
  correo: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
  codigo: 'M7 20l4-16m2 16l4-16M6 9h14M4 15h14',
  celular: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z',
  carpeta: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
}

function Icono({ d, className = 'w-4 h-4' }) {
  return (
    <svg className={className} fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={d} />
    </svg>
  )
}

function Campo({ icono, etiqueta, valor }) {
  return (
    <div className="flex items-start gap-2">
      <Icono d={icono} className="w-4 h-4 mt-0.5 text-gray-400 shrink-0" />
      <div className="min-w-0">
        <p className="text-xs text-gray-500">{etiqueta}</p>
        <p className="text-sm font-semibold text-gray-800 break-words">{valor || '—'}</p>
      </div>
    </div>
  )
}

export default function PerfilPage() {
  const { puede } = useAuth()
  const [datos, setDatos] = useState(null)
  const [error, setError] = useState('')

  useEffect(() => {
    let cancelado = false
    api('/api/perfil')
      .then(d => { if (!cancelado) setDatos(d) })
      .catch(e => { if (!cancelado) setError(e.message) })
    return () => { cancelado = true }
  }, [])

  if (error) return <p className="text-red-700">{error}</p>
  if (!datos) return <p className="text-gray-500">Cargando perfil...</p>

  const mostrarCasos = puede('CASOS', 'ver')

  return (
    <div className="max-w-6xl space-y-6">
      {/* Tarjeta superior */}
      <section className="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between gap-4">
        <div className="flex items-center gap-6 min-w-0">
          <div className="w-28 h-28 shrink-0 rounded-full bg-gray-200 grid place-items-center text-gray-500">
            <Icono d={ICONOS.user} className="w-12 h-12" />
          </div>
          <div className="min-w-0">
            <h1 className="text-2xl font-bold" style={{ color: ROJO }}>{datos.nombre}</h1>
            <p className="text-gray-600">{datos.cargo}</p>
          </div>
        </div>
        <img src={logoUfpso} alt="UFPSO" className="h-16 w-auto object-contain shrink-0" />
      </section>

      <h2 className="text-xl font-bold" style={{ color: ROJO }}>Información Personal</h2>

      <div className={`grid gap-6 ${mostrarCasos ? 'lg:grid-cols-[1fr_16rem]' : ''}`}>
        <section className="bg-white rounded-xl shadow-sm p-6 grid sm:grid-cols-2 gap-x-8 gap-y-6 content-start">
          <Campo icono={ICONOS.documento} etiqueta="Documento" valor={datos.documento} />
          <Campo icono={ICONOS.correo} etiqueta="Correo electrónico" valor={datos.email} />
          <Campo icono={ICONOS.codigo} etiqueta="Código" valor={datos.codigo} />
          <Campo icono={ICONOS.celular} etiqueta="Celular" valor={datos.celular} />
        </section>

        {mostrarCasos && (
          <aside className="bg-white rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 text-center">
            <div className="w-12 h-12 rounded-full bg-blue-100 text-blue-600 grid place-items-center">
              <Icono d={ICONOS.carpeta} className="w-6 h-6" />
            </div>
            <p className="text-sm text-gray-700">Casos en trámite</p>
            {datos.casosEnTramite != null ? (
              <p className="text-3xl font-bold" style={{ color: ROJO }}>{datos.casosEnTramite}</p>
            ) : (
              <span className="block w-10 h-1 rounded" style={{ backgroundColor: ROJO }} />
            )}
          </aside>
        )}
      </div>
    </div>
  )
}
