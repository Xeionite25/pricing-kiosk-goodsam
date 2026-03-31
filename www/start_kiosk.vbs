Set objShell = CreateObject("WScript.Shell")
Set objFSO = CreateObject("Scripting.FileSystemObject")
Set objWMIService = GetObject("winmgmts:\\.\root\cimv2")

' Get current directory (where start.vbs is located) - this is your project root
strProjectRoot = objFSO.GetParentFolderName(WScript.ScriptFullName)
objShell.CurrentDirectory = strProjectRoot

' Build paths dynamically
strPhpExe = strProjectRoot & "\php\php.exe"
strPhpIni = strProjectRoot & "\php\php.ini"

' Check if PHP exists
If Not objFSO.FileExists(strPhpExe) Then
    MsgBox "PHP not found at: " & strPhpExe & vbCrLf & "Please make sure portable PHP is in the 'php' folder.", vbCritical, "Error"
    WScript.Quit
End If

' Start PHP server (hidden)
objShell.Run """" & strPhpExe & """ -c """ & strPhpIni & """ -S localhost:8000 -t . router.php", 0, False

' Wait for server to start
WScript.Sleep 2000

url = "http://localhost:8000/GS/index.php"

' Function to find browser
Function FindBrowser(browserExe)
    Dim browserPaths, path
    browserPaths = Array( _
        "C:\Program Files\" & browserExe, _
        "C:\Program Files (x86)\" & browserExe, _
        "C:\Program Files\Microsoft\Edge\Application\" & browserExe, _
        "C:\Program Files (x86)\Microsoft\Edge\Application\" & browserExe, _
        "C:\Program Files\Google\Chrome\Application\" & browserExe, _
        "C:\Program Files (x86)\Google\Chrome\Application\" & browserExe, _
        "C:\Program Files\Vivaldi\Application\" & browserExe, _
        "C:\Program Files (x86)\Vivaldi\Application\" & browserExe _
    )
    
    For Each path In browserPaths
        If objFSO.FileExists(path) Then
            FindBrowser = path
            Exit Function
        End If
    Next
    FindBrowser = ""
End Function

' Try browsers in order
Dim browserPath, browserPID
browserPath = FindBrowser("msedge.exe")
If browserPath = "" Then browserPath = FindBrowser("chrome.exe")
If browserPath = "" Then browserPath = FindBrowser("vivaldi.exe")

If browserPath <> "" Then
    ' Start browser and get its Process ID
    objShell.Run """" & browserPath & """ """ & url & """", 1, False
Else
    ' Fallback to default browser
    objShell.Run url, 1, False
End If

' Wait a moment for browser to start
WScript.Sleep 1000

' Get the browser process ID
Set colProcesses = objWMIService.ExecQuery("SELECT ProcessId FROM Win32_Process WHERE Name='" & GetProcessName(browserPath) & "'")
For Each objProcess in colProcesses
    browserPID = objProcess.ProcessId
    Exit For
Next

' Monitor browser process - wait until it closes
Do While True
    Set colProcesses = objWMIService.ExecQuery("SELECT ProcessId FROM Win32_Process WHERE ProcessId=" & browserPID)
    If colProcesses.Count = 0 Then Exit Do
    WScript.Sleep 1000
Loop

' Browser closed - kill PHP server
objShell.Run "taskkill /F /IM php.exe", 0, True

' Function to get process name from path
Function GetProcessName(filePath)
    Dim arrPath, fileName
    arrPath = Split(filePath, "\")
    fileName = arrPath(UBound(arrPath))
    GetProcessName = fileName
End Function
