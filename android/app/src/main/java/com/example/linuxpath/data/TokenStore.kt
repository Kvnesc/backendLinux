package com.example.linuxpath.data

import android.content.Context

class TokenStore(context: Context) {
    private val preferences = context.getSharedPreferences("linuxpath_auth", Context.MODE_PRIVATE)

    fun token(): String? = preferences.getString("token", null)

    fun saveToken(token: String) {
        preferences.edit().putString("token", token).apply()
    }

    fun clear() {
        preferences.edit().clear().apply()
    }
}
