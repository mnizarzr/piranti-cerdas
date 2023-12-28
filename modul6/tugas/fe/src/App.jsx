import { useEffect, useState } from 'react'
import { Bell, BellRinging, Lightbulb, Perspective } from '@phosphor-icons/react'

function App() {

  const [buzzerStatus, setBuzzerStatus] = useState(false) // true = on
  const [ledStatus, setLedStatus] = useState(false) // true = on
  const [mpuStatus, setMpuStatus] = useState(false) // true = tilted ; false = flat

  useEffect(() => {
    const source = new EventSource('//localhost:8071');

    source.onopen = function () {
      console.log("Connection to server opened.");
    };

    source.onmessage = function (e) {
      console.log(e.data);
    };

    source.onerror = function () {
      console.log("EventSource failed.");
    };

    source.addEventListener('mpus', function (event) {
      var data = JSON.parse(event.data)

      console.log(data)

      setLedStatus(data.led_status);
      setBuzzerStatus(data.buzzer_status);
      setMpuStatus(data.tilt)

    }, false);

    return () => source.close();
  }, [])

  return (
    <>
      <div className='container'>
        <div className="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
          <div className="flex flex-col items-center pb-10">
            <Perspective size={64} />
            <h5 className="mb-1 text-xl font-medium text-gray-900 dark:text-white">MPU Status</h5>
            <span className="text-sm text-gray-500 dark:text-gray-400">{mpuStatus ? "Miring" : "Datar"}</span>
          </div>
          <div className="flex flex-col items-center pb-10">
            {buzzerStatus ? <BellRinging size={64} color='red' weight='fill' /> : <Bell size={64} />}
            <h5 className="mb-1 text-xl font-medium text-gray-900 dark:text-white">Buzzer Status</h5>
            <span className="text-sm text-gray-500 dark:text-gray-400">{buzzerStatus ? "ON" : "OFF"}</span>
          </div>
          <div className="flex flex-col items-center pb-10">
            {ledStatus ? <Lightbulb size={64} color='red' weight='fill' /> : <Lightbulb size={64} />}
            <h5 className="mb-1 text-xl font-medium text-gray-900 dark:text-white">LED Status</h5>
            <span className="text-sm text-gray-500 dark:text-gray-400">{ledStatus ? "ON" : "OFF"}</span>
          </div>
        </div>



        <footer className="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
          <div className="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span className="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#" className="hover:underline">Nizar &amp; Geraldi</a>. All Rights Reserved.
            </span>
            <ul className="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
              <li>
                <a href="#" className="hover:underline">Contact</a>
              </li>
            </ul>
          </div>
        </footer>
      </div>




    </>
  )
}

export default App
