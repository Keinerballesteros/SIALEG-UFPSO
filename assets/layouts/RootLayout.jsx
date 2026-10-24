import { Outlet } from 'react-router-dom'
import Header from '../components/Header'

export default function RootLayout() {
  return (
    <div className="min-h-screen flex flex-col bg-slate-100">
      <Header />
      <div className="flex-1 flex flex-col"><Outlet /></div>
      <footer className="bg-white/10 py-2 text-center text-xs text-gray-700 font-bold">
          © 2026. Desarrollado por Keiner Ballesteros &amp; Santiago Guevara
        </footer>
    </div>
  )
}
