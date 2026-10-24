import { useState } from 'react'
import { Navigate } from 'react-router-dom'
import { useAuth } from '../../auth/AuthContext'
import logoSialeg from '../../images/logoSIALEG.png'
import logoHorizontalUFPSO from '../../images/logoHorizontalUFPSO.png'
import monumento from '../../images/monumentoUFPSO.jpeg'
import logoConsultorio from '../../images/logoConsultorio2.png'

export default function LoginPage() {
  const { usuario, menu, login } = useAuth()
  const [documento, setDocumento] = useState('')
  const [password, setPassword] = useState('')
  const [showPassword, setShowPassword] = useState(false)
  const [error, setError] = useState('')
  const [loading, setLoading] = useState(false)
  const [aviso, setAviso] = useState('')

  // Si ya hay sesión, va directo a la primera opción de su menú
  if (usuario) return <Navigate to={menu[0]?.ruta ?? '/'} replace />

  async function enviar(e) {
    e.preventDefault()
    setError('')

    if (!documento || !password) {
      setError('Por favor complete todos los campos')
      return
    }

    setLoading(true)
    try {
      await login(documento, password)   // al guardar el usuario, el <Navigate> de arriba redirige
    } catch (err) {
      setError(err.message || 'Credenciales inválidas')
      setLoading(false)
    }
  }

  function proximamente(e) {
    e?.preventDefault()
    setAviso('Esta funcionalidad estará disponible próximamente.')
  }

  return (
    <div className="min-h-screen flex flex-col md:flex-row bg-white font-sans">
      {/* ── Columna izquierda ── */}
      <div className="md:w-4/5 w-full bg-[#f7f7f7] text-white flex flex-col justify-between">
        <div className="bg-[#f7f7f7]">
          <div style={{ backgroundColor: '#e2001a' }} className="p-2">
            <img src={logoSialeg} alt="SIALEG" className="h-12 bg-white" />
          </div>

          <div
            className="bg-cover bg-center bg-no-repeat rounded-md p-6 flex text-black items-center justify-start h-[24rem]"
            style={{
              backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(${monumento})`,
            }}
          >
            <h1 className="text-3xl md:text-4xl font-bold leading-snug text-white">
              Bienvenidos al Sistema de Información<br />
              del Consultorio Jurídico de la UFPSO
            </h1>
          </div>

          <div className="flex gap-4 px-8 mt-10">
            <div
              className="bg-cover bg-center bg-no-repeat rounded-md p-6 flex items-end h-[12rem] w-3/4 shadow-lg hover:opacity-70 cursor-pointer transition"
              style={{
                backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url(${logoConsultorio})`,
              }}
            >
              <a href="https://www.facebook.com/p/Consultorio-Jur%C3%ADdico-UFPSO-100054360678299/?locale=es_LA">
                <div className="bg-black/40 text-white p-6 rounded-md">
                  <p className="text-2xl font-bold">Noticias y Eventos</p>
                  <p className="text-base">Consultorio Jurídico UFPSO</p>
                </div>
              </a>
            </div>

            <div className="flex flex-col gap-8 w-1/4">
              <button
                type="button"
                onClick={proximamente}
                className="flex-1 flex items-center justify-center hover:opacity-70 transition text-white font-semibold px-6 py-1 rounded shadow text-center cursor-pointer"
                style={{ backgroundColor: '#e2001a' }}
              >
                ¡Consulta tu proceso aquí!
              </button>
              <a
                href="https://consultoriojuridicovirtual.ufpso.edu.co/"
                className="flex-1 flex items-center justify-center hover:opacity-70 transition text-white font-semibold px-6 py-1 rounded shadow text-center"
                style={{ backgroundColor: '#e2001a' }}
              >
                Ir al Consultorio Jurídico Virtual
              </a>
            </div>
          </div>
        </div>

        <footer className="bg-white/10 py-2 text-center text-xs text-gray-700 font-bold">
          © 2026. Desarrollado por Keiner Ballesteros &amp; Santiago Guevara
        </footer>
      </div>

      {/* ── Columna derecha: inicio de sesión ── */}
      <div className="md:w-1/5 w-full bg-[#f7f7f7] flex flex-col shadow-lg">
        <div className="flex justify-start mb-8 px-4 py-2">
          <img src={logoHorizontalUFPSO} alt="UFPS" className="h-24 object-contain" />
        </div>

        <h2 className="text-2xl font-bold text-gray-800 mb-6 text-center">Inicio de Sesión</h2>

        <form onSubmit={enviar}>
          <div className="space-y-5 px-8">
            {error && (
              <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {error}
              </div>
            )}

            {/* Documento */}
            <div className="relative">
              <div className="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
              </div>
              <input
                type="text"
                inputMode="numeric"
                autoComplete="username"
                placeholder="Documento"
                value={documento}
                onChange={e => setDocumento(e.target.value.replace(/\D/g, '').substring(0, 10))}
                maxLength={10}
                className="w-full border border-gray-300 placeholder:font-bold rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-[#e2001a] outline-none"
                required
              />
            </div>

            {/* Contraseña */}
            <div>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                  <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input
                  type={showPassword ? 'text' : 'password'}
                  id="password"
                  autoComplete="current-password"
                  placeholder="Contraseña"
                  value={password}
                  onChange={e => setPassword(e.target.value)}
                  className="w-full border placeholder:font-bold border-gray-300 rounded-lg pl-12 pr-12 py-3 focus:ring-2 focus:ring-[#e2001a] outline-none"
                  required
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(!showPassword)}
                  className="absolute inset-y-0 right-0 flex items-center pr-4 hover:opacity-70 cursor-pointer"
                  aria-label={showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'}
                >
                  {showPassword ? (
                    <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  ) : (
                    <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  )}
                </button>
              </div>
              <a
                href="#"
                onClick={proximamente}
                className="text-sm hover:underline mt-2 block text-right"
                style={{ color: '#e2001a' }}
              >
                ¿Olvidaste tu contraseña?
              </a>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full text-white font-semibold py-2 mt-12 rounded-lg transition hover:opacity-70 cursor-pointer disabled:opacity-50"
              style={{ backgroundColor: '#e2001a' }}
            >
              {loading ? 'Ingresando...' : 'Ingresar'}
            </button>
          </div>
        </form>
      </div>

      {/* Aviso temporal para las funciones que aún no existen */}
      {aviso && (
        <div
          role="status"
          className="fixed bottom-4 right-4 z-50 bg-white border-l-4 border-[#e2001a] shadow-lg rounded px-4 py-3 text-sm text-gray-800"
        >
          {aviso}
          <button onClick={() => setAviso('')} className="ml-3 font-bold cursor-pointer" aria-label="Cerrar">
            ×
          </button>
        </div>
      )}
    </div>
  )
}
