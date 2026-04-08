"use client"

import { useEffect, useRef } from "react"

export function AnimatedGrid() {
  const canvasRef = useRef<HTMLCanvasElement>(null)

  useEffect(() => {
    const canvas = canvasRef.current
    if (!canvas) return

    const ctx = canvas.getContext("2d")
    if (!ctx) return

    let animationId: number
    let time = 0

    const resize = () => {
      canvas.width = canvas.offsetWidth * window.devicePixelRatio
      canvas.height = canvas.offsetHeight * window.devicePixelRatio
      ctx.scale(window.devicePixelRatio, window.devicePixelRatio)
    }

    resize()
    window.addEventListener("resize", resize)

    const draw = () => {
      const width = canvas.offsetWidth
      const height = canvas.offsetHeight

      ctx.clearRect(0, 0, width, height)

      const gridSize = 60
      const cols = Math.ceil(width / gridSize) + 1
      const rows = Math.ceil(height / gridSize) + 1

      // Draw animated grid lines
      for (let i = 0; i < cols; i++) {
        const x = i * gridSize
        const wave = Math.sin(time * 0.5 + i * 0.3) * 0.5 + 0.5
        ctx.beginPath()
        ctx.moveTo(x, 0)
        ctx.lineTo(x, height)
        ctx.strokeStyle = `rgba(16, 185, 129, ${0.03 + wave * 0.04})`
        ctx.lineWidth = 1
        ctx.stroke()
      }

      for (let j = 0; j < rows; j++) {
        const y = j * gridSize
        const wave = Math.sin(time * 0.5 + j * 0.3) * 0.5 + 0.5
        ctx.beginPath()
        ctx.moveTo(0, y)
        ctx.lineTo(width, y)
        ctx.strokeStyle = `rgba(16, 185, 129, ${0.03 + wave * 0.04})`
        ctx.lineWidth = 1
        ctx.stroke()
      }

      // Draw intersection points with pulse effect
      for (let i = 0; i < cols; i++) {
        for (let j = 0; j < rows; j++) {
          const x = i * gridSize
          const y = j * gridSize
          const pulse = Math.sin(time * 2 + i * 0.5 + j * 0.5) * 0.5 + 0.5

          ctx.beginPath()
          ctx.arc(x, y, 2 + pulse * 2, 0, Math.PI * 2)
          ctx.fillStyle = `rgba(16, 185, 129, ${0.1 + pulse * 0.2})`
          ctx.fill()
        }
      }

      time += 0.016
      animationId = requestAnimationFrame(draw)
    }

    draw()

    return () => {
      window.removeEventListener("resize", resize)
      cancelAnimationFrame(animationId)
    }
  }, [])

  return (
    <canvas
      ref={canvasRef}
      className="absolute inset-0 w-full h-full pointer-events-none"
      style={{ opacity: 0.6 }}
    />
  )
}
