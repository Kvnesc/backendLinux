package com.example.linuxpath.ui.auth

import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.example.linuxpath.R
import com.example.linuxpath.data.LinuxRepository
import com.example.linuxpath.ui.common.userMessage
import com.example.linuxpath.ui.main.MainActivity
import kotlinx.coroutines.launch

class AuthActivity : AppCompatActivity() {
    private lateinit var repository: LinuxRepository
    private lateinit var nameInput: EditText
    private lateinit var emailInput: EditText
    private lateinit var passwordInput: EditText
    private lateinit var loading: ProgressBar
    private lateinit var errorText: TextView
    private lateinit var loginButton: Button
    private lateinit var registerButton: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        repository = LinuxRepository(this)

        if (repository.hasSession()) {
            openHome()
            return
        }

        setContentView(R.layout.activity_auth)
        nameInput = findViewById(R.id.nameInput)
        emailInput = findViewById(R.id.emailInput)
        passwordInput = findViewById(R.id.passwordInput)
        loading = findViewById(R.id.loading)
        errorText = findViewById(R.id.errorText)
        loginButton = findViewById(R.id.loginButton)
        registerButton = findViewById(R.id.registerButton)

        loginButton.setOnClickListener { authenticate(false) }
        registerButton.setOnClickListener { authenticate(true) }
    }

    private fun authenticate(register: Boolean) {
        val email = emailInput.text.toString()
        val password = passwordInput.text.toString()
        val name = nameInput.text.toString()

        if (email.isBlank() || password.length < 8 || (register && name.isBlank())) {
            showError("Ingresa correo, contraseña de al menos 8 caracteres${if (register) " y nombre" else ""}.")
            return
        }

        setLoading(true)
        lifecycleScope.launch {
            runCatching {
                if (register) repository.register(name, email, password)
                else repository.login(email, password)
            }.onSuccess {
                openHome()
            }.onFailure {
                showError(it.userMessage())
                setLoading(false)
            }
        }
    }

    private fun setLoading(value: Boolean) {
        loading.visibility = if (value) View.VISIBLE else View.GONE
        loginButton.isEnabled = !value
        registerButton.isEnabled = !value
    }

    private fun showError(message: String) {
        errorText.text = message
        errorText.visibility = View.VISIBLE
    }

    private fun openHome() {
        startActivity(Intent(this, MainActivity::class.java))
        finish()
    }
}
