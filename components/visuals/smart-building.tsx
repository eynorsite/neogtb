"use client"

import { useEffect, useState } from "react"

export function SmartBuilding({ className = "" }: { className?: string }) {
  const [activeFloors, setActiveFloors] = useState<number[]>([])
  const [dataPoints, setDataPoints] = useState<{ id: number; active: boolean }[]>([])

  useEffect(() => {
    // Initialize data points
    setDataPoints(
      Array.from({ length: 12 }, (_, i) => ({ id: i, active: false }))
    )

    // Animate floors
    const floorInterval = setInterval(() => {
      setActiveFloors((prev) => {
        const newActive = [...prev]
        const randomFloor = Math.floor(Math.random() * 5)
        if (newActive.includes(randomFloor)) {
          return newActive.filter((f) => f !== randomFloor)
        }
        return [...newActive, randomFloor].slice(-3)
      })
    }, 800)

    // Animate data points
    const dataInterval = setInterval(() => {
      setDataPoints((prev) =>
        prev.map((p) => ({
          ...p,
          active: Math.random() > 0.6,
        }))
      )
    }, 500)

    return () => {
      clearInterval(floorInterval)
      clearInterval(dataInterval)
    }
  }, [])

  return (
    <div className={`relative ${className}`}>
      <svg viewBox="0 0 400 500" className="w-full h-full">
        <defs>
          <linearGradient id="buildingGradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stopColor="#102A43" />
            <stop offset="100%" stopColor="#0a1929" />
          </linearGradient>
          <linearGradient id="glassGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stopColor="rgba(16, 185, 129, 0.3)" />
            <stop offset="100%" stopColor="rgba(16, 185, 129, 0.1)" />
          </linearGradient>
          <linearGradient id="activeGlow" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stopColor="#10b981" />
            <stop offset="100%" stopColor="#34d399" />
          </linearGradient>
          <filter id="glow">
            <feGaussianBlur stdDeviation="3" result="coloredBlur" />
            <feMerge>
              <feMergeNode in="coloredBlur" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>
        </defs>

        {/* Building base */}
        <rect
          x="80"
          y="50"
          width="240"
          height="400"
          rx="8"
          fill="url(#buildingGradient)"
          className="drop-shadow-2xl"
        />

        {/* Building floors with windows */}
        {[0, 1, 2, 3, 4].map((floor) => (
          <g key={floor}>
            {/* Floor section */}
            <rect
              x="90"
              y={70 + floor * 75}
              width="220"
              height="65"
              rx="4"
              fill={activeFloors.includes(floor) ? "url(#activeGlow)" : "rgba(255,255,255,0.05)"}
              className="transition-all duration-500"
              style={{
                filter: activeFloors.includes(floor) ? "url(#glow)" : "none",
              }}
            />
            {/* Windows */}
            {[0, 1, 2, 3].map((win) => (
              <rect
                key={win}
                x={105 + win * 52}
                y={80 + floor * 75}
                width="40"
                height="45"
                rx="2"
                fill={
                  activeFloors.includes(floor)
                    ? "rgba(16, 185, 129, 0.8)"
                    : "url(#glassGradient)"
                }
                className="transition-all duration-300"
              />
            ))}
          </g>
        ))}

        {/* Antenna / Smart sensors */}
        <rect x="190" y="20" width="20" height="30" rx="2" fill="#102A43" />
        <circle
          cx="200"
          cy="15"
          r="8"
          fill="#10b981"
          className="animate-pulse"
          filter="url(#glow)"
        />

        {/* Data flow lines */}
        {dataPoints.map((point, i) => {
          const startX = 200
          const startY = 15
          const endX = 50 + (i % 4) * 100
          const endY = 100 + Math.floor(i / 4) * 150

          return (
            <g key={point.id}>
              <path
                d={`M${startX},${startY} Q${startX},${endY} ${endX},${endY}`}
                fill="none"
                stroke={point.active ? "#10b981" : "rgba(16, 185, 129, 0.2)"}
                strokeWidth={point.active ? 2 : 1}
                strokeDasharray={point.active ? "none" : "4,4"}
                className="transition-all duration-300"
                filter={point.active ? "url(#glow)" : "none"}
              />
              <circle
                cx={endX}
                cy={endY}
                r={point.active ? 6 : 4}
                fill={point.active ? "#10b981" : "rgba(16, 185, 129, 0.3)"}
                className="transition-all duration-300"
                filter={point.active ? "url(#glow)" : "none"}
              />
            </g>
          )
        })}

        {/* Ground */}
        <rect x="60" y="450" width="280" height="8" rx="4" fill="#e4e4e7" />
      </svg>

      {/* Floating labels */}
      <div className="absolute top-4 right-4 space-y-2">
        <div className="flex items-center gap-2 px-3 py-1.5 rounded-full bg-accent-500/10 border border-accent-500/20 text-xs font-medium text-accent-600">
          <span className="w-2 h-2 rounded-full bg-accent-500 animate-pulse" />
          CVC Optimisé
        </div>
        <div className="flex items-center gap-2 px-3 py-1.5 rounded-full bg-gold-500/10 border border-gold-500/20 text-xs font-medium text-gold-600">
          <span className="w-2 h-2 rounded-full bg-gold-500 animate-pulse" />
          -35% Énergie
        </div>
      </div>
    </div>
  )
}
