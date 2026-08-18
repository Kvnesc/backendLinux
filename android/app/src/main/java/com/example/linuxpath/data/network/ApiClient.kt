package com.example.linuxpath.data.network

import android.content.Context
import com.example.linuxpath.BuildConfig
import com.example.linuxpath.data.TokenStore
import okhttp3.Interceptor
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ApiClient {
    @Volatile private var service: ApiService? = null

    fun service(context: Context): ApiService {
        return service ?: synchronized(this) {
            service ?: build(context.applicationContext).also { service = it }
        }
    }

    private fun build(context: Context): ApiService {
        val tokenStore = TokenStore(context)
        val authInterceptor = Interceptor { chain ->
            val request = chain.request().newBuilder()
                .addHeader("Accept", "application/json")
                .apply {
                    tokenStore.token()?.let { token ->
                        addHeader("Authorization", "Bearer $token")
                    }
                }
                .build()
            chain.proceed(request)
        }

        val client = OkHttpClient.Builder()
            .addInterceptor(authInterceptor)
            .build()

        return Retrofit.Builder()
            .baseUrl(BuildConfig.API_BASE_URL)
            .client(client)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiService::class.java)
    }
}
