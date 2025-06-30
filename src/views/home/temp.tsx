import React, { useState, useEffect } from "react"
import { Play, ArrowRight, Shield, Trophy, Users, Star } from "lucide-react"

interface IntroPageProps {
  onEnter: () => void
}

const IntroPage: React.FC<IntroPageProps> = ({ onEnter }) => {
  const [isLoaded, setIsLoaded] = useState(false)

  useEffect(() => {
    const timer = setTimeout(() => setIsLoaded(true), 500)
    return () => clearTimeout(timer)
  }, [])

  return (
    <div className="min-h-screen relative overflow-hidden">
      {/* Background Image */}
      <div
        className="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style={{
          backgroundImage: "url(/src/assets/intro-bg.webp)",
        }}
      >
        {/* Dark Overlay */}
        <div className="absolute inset-0 bg-black/40"></div>

        {/* Gradient Overlay for better text readability */}
        <div className="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-purple-900/30"></div>
      </div>

      {/* Content Container */}
      <div className="relative z-10 min-h-screen flex items-center">
        <div className="container mx-auto px-6 lg:px-12">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Left Side - Main Title */}
            <div
              className={`space-y-8 transform transition-all duration-1000 ${
                isLoaded ? "translate-x-0 opacity-100" : "-translate-x-10 opacity-0"
              }`}
            >
              <div className="space-y-4">
                <div className="inline-flex items-center px-4 py-2 bg-red-600/20 backdrop-blur-sm rounded-full border border-red-500/30">
                  <Shield className="w-4 h-4 text-red-400 mr-2" />
                  <span className="text-red-300 text-sm font-medium">VALORANT ACCOUNTS</span>
                </div>

                <h1 className="text-5xl lg:text-7xl font-bold text-white leading-tight">
                  THUÊ ACC
                  <span className="block text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-pink-500 to-purple-600">
                    VALORANT
                  </span>
                  <span className="block text-3xl lg:text-4xl text-gray-300 font-normal">
                    CHẤT LƯỢNG CAO
                  </span>
                </h1>

                <p className="text-xl text-gray-300 max-w-lg leading-relaxed">
                  Trải nghiệm Valorant với những tài khoản premium, rank cao, skin đẹp. Dịch vụ uy
                  tín, giá cả hợp lý.
                </p>
              </div>

              {/* Stats */}
              <div className="grid grid-cols-3 gap-6">
                <div className="text-center">
                  <div className="text-3xl font-bold text-white">500+</div>
                  <div className="text-gray-400 text-sm">Tài khoản</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-white">98%</div>
                  <div className="text-gray-400 text-sm">Hài lòng</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-white">24/7</div>
                  <div className="text-gray-400 text-sm">Hỗ trợ</div>
                </div>
              </div>

              {/* CTA Button */}
              <button
                onClick={onEnter}
                className="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-red-500/25"
              >
                <Play className="w-5 h-5 mr-3 group-hover:translate-x-1 transition-transform" />
                BẮT ĐẦU NGAY
                <ArrowRight className="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" />
              </button>
            </div>

            {/* Right Side - Introduction Panel */}
            <div
              className={`transform transition-all duration-1000 delay-300 ${
                isLoaded ? "translate-x-0 opacity-100" : "translate-x-10 opacity-0"
              }`}
            >
              <div className="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
                <div className="space-y-6">
                  {/* Header */}
                  <div className="text-center pb-6 border-b border-white/20">
                    <h2 className="text-2xl font-bold text-white mb-2">Tại sao chọn chúng tôi?</h2>
                    <p className="text-gray-300">Dịch vụ thuê acc Valorant hàng đầu Việt Nam</p>
                  </div>

                  {/* Features */}
                  <div className="space-y-4">
                    <div className="flex items-start space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                      <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Shield className="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h3 className="text-white font-semibold mb-1">Bảo mật tuyệt đối</h3>
                        <p className="text-gray-400 text-sm">
                          Tài khoản được bảo vệ 100%, không lo bị khóa
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                      <div className="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Trophy className="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h3 className="text-white font-semibold mb-1">Rank cao, skin đẹp</h3>
                        <p className="text-gray-400 text-sm">
                          Từ Iron đến Radiant, skin hiếm và độc quyền
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                      <div className="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Users className="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h3 className="text-white font-semibold mb-1">Hỗ trợ 24/7</h3>
                        <p className="text-gray-400 text-sm">
                          Đội ngũ hỗ trợ chuyên nghiệp, sẵn sàng giúp đỡ
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                      <div className="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Star className="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h3 className="text-white font-semibold mb-1">Giá cả hợp lý</h3>
                        <p className="text-gray-400 text-sm">
                          Mức giá cạnh tranh, nhiều gói ưu đãi hấp dẫn
                        </p>
                      </div>
                    </div>
                  </div>

                  {/* Contact Info */}
                  <div className="pt-6 border-t border-white/20">
                    <div className="text-center space-y-2">
                      <p className="text-white font-semibold">Liên hệ ngay:</p>
                      <div className="flex justify-center space-x-4 text-sm">
                        <span className="text-blue-400">Facebook: /valorantacc</span>
                        <span className="text-green-400">Zalo: 0123456789</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom Scroll Indicator */}
      <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2">
        <div className="animate-bounce">
          <div className="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
            <div className="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default IntroPage
