# Proguard / R8 configuration for LinuxPath Production Release

-keepattributes Signature
-keepattributes *Annotation*
-keepattributes EnclosingMethod
-keepattributes InnerClasses

# Preserve Data DTO Models for Gson deserialization
-keep class com.example.linuxpath.data.model.** { *; }
-keepclassmembers class com.example.linuxpath.data.model.** { *; }

# Retrofit 2 & 3 Rules
-keep class retrofit2.** { *; }
-keepclasseswithmembers class * {
    @retrofit2.http.* <methods>;
}

# Gson Rules
-keepclassmembers class * implements ::com.google.gson.TypeAdapter {
    public <init>(...);
}
-keep class com.google.gson.reflect.TypeToken { *; }
-keepclassmembers class * {
    @com.google.gson.annotations.SerializedName <fields>;
}

# Android Core / Kotlin Coroutines
-dontwarn javax.annotation.**
-dontwarn org.codehaus.mojo.animal_sniffer.IgnoreJRERequirement
