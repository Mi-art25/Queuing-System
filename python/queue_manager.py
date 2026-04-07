class SingleQueue:
    def __init__(self, start=1, end=100, prefix=''):
        self.prefix = prefix
        self.reset(start, end)

    def reset(self, start=1, end=100):
        self.start = start
        self.end = end
        self.pending = list(range(start, end + 1))
        self.current = None
        self.next_number = self.pending[0] if self.pending else None
        self.catered = []
        self.skipped = []

    def fmt(self, n):
        return f"{self.prefix}{n}" if n is not None else None

    def next(self):
        if not self.pending:
            return {"error": "No more numbers in queue"}
        if self.current is not None:
            self.catered.append(self.current)
        self.current = self.pending.pop(0)
        self.next_number = self.pending[0] if self.pending else None
        return self.status()

    def skip(self):
        if self.current is None:
            return {"error": "No current number to skip"}
        self.skipped.append(self.current)
        if not self.pending:
            self.current = None
            self.next_number = None
            return self.status()
        self.current = self.pending.pop(0)
        self.next_number = self.pending[0] if self.pending else None
        return self.status()

    def status(self):
        return {
            "current": self.fmt(self.current),
            "next": self.fmt(self.next_number),
            "pending": [self.fmt(n) for n in self.pending[:10]],
            "pending_count": len(self.pending),
            "catered": [self.fmt(n) for n in self.catered[-10:]],
            "skipped": [self.fmt(n) for n in self.skipped],
        }


class QueueManager:
    def __init__(self):
        self.regular = SingleQueue(start=1, end=100, prefix='')
        self.priority = SingleQueue(start=1, end=100, prefix='')

    def get_queue(self, queue_type: str) -> SingleQueue:
        if queue_type == 'priority':
            return self.priority
        return self.regular