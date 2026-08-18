package com.example.linuxpath.ui.common

import retrofit2.HttpException

fun Throwable.userMessage(): String = when (this) {
    is HttpException -> when (code()) {
        401 -> "Sesión inválida o credenciales incorrectas."
        422 -> "Revisa los datos ingresados."
        else -> "El servidor respondió con error ${code()}."
    }
    else -> message ?: "No fue posible conectar con el servidor."
}
